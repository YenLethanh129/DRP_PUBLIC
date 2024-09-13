<?php

namespace App\Controllers;

class BmiController extends BaseController
{
    public function index()
    {
        if(isset($_SESSION['logged_in']))
        {
            $this->loadView('pages.bmi');
        }
        else
        {
            echo '<script>
            alert("Please log in to use this feature!");
            window.location.href = "/registery";
            </script>';
        }
    }


}
