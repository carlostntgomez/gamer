<?php

echo "--- Iniciando script de prueba de imagen ---\n";

$sourcePath = storage_path('app/public/tinker_test/test.jpg');
$destinationPath = storage_path('app/public/tinker_test/test.webp');

// 1. Check if source file exists
if (!file_exists($sourcePath)) {
    echo "Error: El archivo fuente no existe en: {$sourcePath}\n";
    return;
}
echo "Paso 1: El archivo fuente existe.\n";

// 2. Read file content
$imageContent = file_get_contents($sourcePath);
if ($imageContent === false) {
    echo "Error: No se pudo leer el contenido del archivo de imagen.\n";
    return;
}
echo "Paso 2: Contenido del archivo leído con éxito.\n";

// 3. Create image from string
if (!function_exists('imagecreatefromstring')) {
    echo "Error Fatal: La función 'imagecreatefromstring' no existe.\n";
    return;
}
$image = @imagecreatefromstring($imageContent);
if ($image === false) {
    echo "Error Fatal: imagecreatefromstring() falló. GD no puede procesar el formato de la imagen (probablemente JPEG).\n";
    if (!function_exists('imagecreatefromjpeg')) {
        echo "Diagnóstico: La función 'imagecreatefromjpeg' no existe. El soporte para JPEG en GD está ausente.\n";
    } else {
        echo "Diagnóstico: El soporte para JPEG existe, el problema puede ser un archivo corrupto o memoria insuficiente.\n";
    }
    return;
}
echo "Paso 3: Imagen creada desde el string con éxito.\n";

// 4. Scale image
if (!function_exists('imagescale')) {
    echo "Error Fatal: La función 'imagescale' no existe.\n";
    imagedestroy($image);
    return;
}
$scaledImage = imagescale($image, 800);
if ($scaledImage === false) {
    echo "Error: imagescale() falló.\n";
    imagedestroy($image);
    return;
}
echo "Paso 4: Imagen redimensionada con éxito.\n";

// 5. Save as WebP
if (!function_exists('imagewebp')) {
    echo "Error Fatal: La función 'imagewebp' no existe.\n";
    imagedestroy($image);
    imagedestroy($scaledImage);
    return;
}
$result = imagewebp($scaledImage, $destinationPath, 80);
if ($result === false) {
    echo "Error: imagewebp() falló al guardar el archivo.\n";
    imagedestroy($image);
    imagedestroy($scaledImage);
    return;
}
echo "Paso 5: Imagen guardada como WebP con éxito en: {$destinationPath}\n";

// 6. Clean up resources
imagedestroy($image);
imagedestroy($scaledImage);

// 7. Verify file creation
if (file_exists($destinationPath)) {
    echo "Paso 6: Verificación final - El archivo test.webp EXISTE en el disco.\n";
} else {
    echo "Paso 6: Verificación final - El archivo test.webp NO se encontró después de la operación.\n";
}

echo "--- Fin del script de prueba ---\n";
