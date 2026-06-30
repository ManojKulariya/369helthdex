// app/View/Components/Footer.php

namespace App\View\Components;

use Illuminate\View\Component;

class Footer extends Component
{
    public $footerdata; // You can define any data you want to pass to the component.

    public function __construct()
    {
        $data= "component";
        $this->footerdata =$data
    }

    public function render()
    {
        return view('components.footer');
    }
}
