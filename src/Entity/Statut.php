<?php

namespace SDIS62\Core\Ops\Entity;

use MabeEnum\Enum;

class Statut extends Enum
{
    const DISPONIBLE                  = 1;
    const DISPONIBLE_MAIS_NON_ARMABLE = 2;
    const SELECTIONNE                 = 3;
    const EN_ALERTE                   = 4;
    const EN_ROUTE                    = 5;
    const SUR_LES_LIEUX               = 6;
    const TRANSPORT_HOPITAL           = 7;
    const ARRIVEE_HOPITAL             = 8;
    const QUITTE_HOPITAL              = 9;
    const DISPONIBLE_RADIO            = 10;
    const MOBILISE_CENTRE             = 11;
    const RETOUR_NON_OPERATIONNEL     = 12;
    const INDISPONIBLE                = 13;
    const OPERATION_MULTIPLE          = 14;
    const RONDE                       = 15;
    const RECONSTITUTION              = 16;
    const QUITTE_LES_LIEUX            = 17;
    const MOBILISE_SUR_LES_LIEUX      = 18;
}
