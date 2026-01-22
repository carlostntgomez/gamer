<?php

namespace App\Filament\Actions;

use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class GeneratePostContentAction extends Action
{
    public static function make(?string $name = 'generateContent'): static
    {
        return parent::make($name)
            ->label('Generar Contenido con IA')
            ->icon('heroicon-o-sparkles')
            ->color('primary')
            ->action(function (Forms\Set $set, Forms\Get $get) {
                $apiKey = config('gemini.api_key');
                $postTitle = $get('title');

                if (empty($apiKey)) {
                    Notification::make()->title('Error')->body('La clave API de Gemini no está configurada.')->danger()->send();
                    return;
                }

                if (empty($postTitle)) {
                    Notification::make()->title('Error')->body('Por favor, introduce el título del post.')->danger()->send();
                    return;
                }

                $prompt = self::buildPrompt($postTitle);
                $schema = self::buildSchema();

                try {
                    $response = Http::withHeaders(['Content-Type' => 'application/json'])
                        ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key=' . $apiKey, [
                            'contents' => [['parts' => [['text' => $prompt]]]],
                            'generationConfig' => [
                                'response_mime_type' => 'application/json',
                                'response_schema' => $schema,
                            ]
                        ]);

                    if ($response->successful()) {
                        $generatedContent = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                        $contentJson = json_decode($generatedContent, true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            self::setFormFields($set, $contentJson);
                            Notification::make()->title('¡Éxito!')->body('El contenido del post ha sido generado.')->success()->send();
                        } else {
                            Notification::make()->title('Error de IA')->body('La IA no devolvió un JSON válido. Respuesta: ' . $generatedContent)->danger()->send();
                        }
                    } else {
                        $errorBody = $response->json();
                        $errorMessage = $errorBody['error']['message'] ?? 'Error desconocido al conectar con la API.';
                        Notification::make()->title('Error de API')->body($errorMessage)->danger()->send();
                    }
                } catch (\Exception $e) {
                    Notification::make()->title('Error de Sistema')->body($e->getMessage())->danger()->send();
                }
            });
    }

    private static function buildPrompt(string $postTitle): string
    {
        return <<<PROMPT
Actúa como un Blogger experto y Estratega SEO para TecnnyGames, una tienda online líder en el sector gaming. Eres conocido por escribir artículos que son a la vez informativos, entretenidos y que posicionan muy bien en Google.

**REGLAS CRÍTICAS e INQUEBRANTABLES:**
- Los límites de caracteres son ESTRICTOS. NUNCA, bajo ninguna circunstancia, debes excederlos.
- `seo_title`: MÁXIMO 60 caracteres.
- `seo_description`: MÁXIMO 160 caracteres.
- `excerpt`: MÁXIMO 255 caracteres.

Tu objetivo es crear un post de blog completo, persuasivo y optimizado para SEO, dirigido a nuestra audiencia de gamers, entusiastas de la tecnología y cultura pop.

Basándote EXCLUSIVAMENTE en el título proporcionado, genera el siguiente contenido:
Título del Post: {$postTitle}
PROMPT;
    }

    private static function buildSchema(): array
    {
        return [
            'type' => 'OBJECT',
            'properties' => [
                'content' => ['type' => 'STRING', 'description' => 'El contenido completo del artículo en formato HTML. Debe estar bien estructurado con encabezados (<h3>, <h4>), listas (<ul><li>), negritas (<strong>), párrafos (<p>). Debe ser informativo, atractivo y relevante para el título. El tono debe ser entusiasta y conocedor del mundo gaming.'],
                'excerpt' => ['type' => 'STRING', 'description' => 'Un extracto o resumen conciso y atractivo del post (máx 255 chars). Ideal para mostrar en listados de blog y redes sociales.'],
                'seo_title' => ['type' => 'STRING', 'description' => 'Título SEO optimizado. REGLA ESTRICTA: NO DEBE SUPERAR los 60 caracteres. Debe ser idéntico o una ligera variación atractiva del título principal.'],
                'seo_description' => ['type' => 'STRING', 'description' => 'Meta descripción SEO persuasiva. REGLA ESTRICTA: NO DEBE SUPERAR los 160 caracteres. Debe resumir el contenido e incitar al clic.'],
                'seo_keywords' => ['type' => 'STRING', 'description' => 'Una lista de 5 a 7 palabras clave y términos de búsqueda relevantes para el post, separadas por comas.'],
            ],
            'required' => ['content', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords']
        ];
    }

    private static function setFormFields(Forms\Set $set, array $contentJson): void
    {
        $set('content', $contentJson['content'] ?? null);

        $excerpt = $contentJson['excerpt'] ?? '';
        if (mb_strlen($excerpt) > 255) {
            $truncated = mb_substr($excerpt, 0, 252);
            $lastSpace = mb_strrpos($truncated, ' ');
            $excerpt = ($lastSpace !== false) ? mb_substr($truncated, 0, $lastSpace) . '...' : $truncated . '...';
        }
        $set('excerpt', $excerpt);

        $seoTitle = $contentJson['seo_title'] ?? '';
        $set('seo_title', mb_strlen($seoTitle) > 60 ? mb_substr($seoTitle, 0, 60) : $seoTitle);

        $seoDescription = $contentJson['seo_description'] ?? '';
        if (mb_strlen($seoDescription) > 160) {
            $truncated = mb_substr($seoDescription, 0, 157);
            $lastSpace = mb_strrpos($truncated, ' ');
            $seoDescription = ($lastSpace !== false) ? mb_substr($truncated, 0, $lastSpace) . '...' : $truncated . '...';
        }
        $set('seo_description', $seoDescription);

        $keywords = $contentJson['seo_keywords'] ?? '';
        $set('seo_keywords', !is_array($keywords) ? array_map('trim', explode(',', $keywords)) : $keywords);
    }
}
