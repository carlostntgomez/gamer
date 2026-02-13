<?php

namespace App\View\Components\Home;

use App\Models\Brand;
use Illuminate\View\Component;

class BrandLogos extends Component
{
    public $brands;
    /**
     * Create a new component instance.
     */
    public function __construct($brands = null)
    {
        // Si no se pasan marcas, obtener todas las visibles por defecto.
        // Esto mantiene el componente funcional si se usa en otros lugares sin datos.
        if ($brands === null) {
            $this->brands = Brand::where('is_visible', true)->get();
        } else {
            // Usar las marcas que se pasan desde el controlador.
            $this->brands = $brands;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.brand-logos');
    }
}
