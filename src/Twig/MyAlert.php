<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MyAlert extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('alert', [$this, 'renderAlert']),
        ];
    }

    public function renderAlert($message = '', $type = 'success')
    {

        $alerticone = [
            'success' => '<i class="fa-solid fa-circle-check"></i>',
            'danger' => '<i class="fa fa-exclamation-circle"></i>',
            'info' => '<i class="fa fa-exclamation-circle"></i>'
        ];
        $icone = $alerticone[ $type ] ; 

        return "<div class=\"my-back-dorp \">
                    <div class=\"myalert\">
                        <div class='my-alert-btn-close'>
                            <button type=\"button\" class=\"btn-close\" onclick=\"close_alert( this )\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                        </div>
                        <div class=\"my-icone-alert text-{$type}\">
                            {$icone}
                        </div>
                        <div class=\"my-texte-alert\">
                            <p>{$message} 😎 </p>
                        </div>
                        <div class=\"my-btn-alert\">
                            <button class='btn  btn-{$type}' onclick=\"close_alert( this )\"><i class=\"fa-solid fa-check\"></i> D'accord</button>
                        </div>
                    </div>
                </div>";
    }
}
