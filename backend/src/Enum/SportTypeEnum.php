<?php

namespace App\Enum;

/**
 * Enum du Type de Sport.<br>
 * Enumération des **types de sports** par le **nombre de compétiteurs par participant**.
 */
enum SportTypeEnum: string
{
    case individuel = 'individuel';
    case equipe = 'equipe';
    case indiEquipe = 'indiEquipe';
}
