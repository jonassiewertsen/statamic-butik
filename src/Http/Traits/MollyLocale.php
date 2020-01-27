<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

trait MollyLocale
{
    private function getLocale()
    {
        switch (app()->getLocale()) {
            case 'en':
                return 'en_US';
                break;
            case 'nl':
                return 'nl_NL';
                break;
            case 'fr':
                return 'fr_FR';
                break;
            case 'de':
                return 'de_DE';
                break;
            case 'es':
                return 'es_ES';
                break;
            case 'ca':
                return 'ca_ES';
                break;
            case 'pt':
                return 'pt_PT';
                break;
            case 'it':
                return 'it_IT';
                break;
            case 'bn':
                return 'nb_NO';
                break;
            case 'sv':
                return 'sv_SE';
                break;
            case 'fi':
                return 'fi_FI';
                break;
            case 'da':
                return 'da_DK';
                break;
            case 'is':
                return 'is_IS';
                break;
            case 'hu':
                return 'hu_HU';
                break;
            case 'pl':
                return 'pl_PL';
                break;
            case 'lv':
                return 'lv_LV';
                break;
            case 'lt':
                return 'lt_LT';
                break;
            default:
                return 'en_US';
        }
    }
}