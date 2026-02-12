<?php

// === CONFIGURATION ===
$srcDir = __DIR__.'/src';
$outputFile = __DIR__.'/../Mesures logiciels.csv';

// === FONCTIONS D'ANALYSE ===

/**
 * Compte les lignes de code (LOC) et les lignes de commentaires (CLOC).
 */
function countLines(string $content): array
{
    $lines = explode("\n", $content);
    $loc = 0;
    $cloc = 0;
    $inBlockComment = false;

    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ('' === $trimmed) {
            continue;
        }

        ++$loc;

        // Bloc de commentaire /** ... */ ou /* ... */
        if ($inBlockComment) {
            ++$cloc;
            if (str_contains($trimmed, '*/')) {
                $inBlockComment = false;
            }
            continue;
        }

        if (str_starts_with($trimmed, '/**') || str_starts_with($trimmed, '/*')) {
            ++$cloc;
            if (!str_contains($trimmed, '*/')) {
                $inBlockComment = true;
            }
            continue;
        }

        // Commentaire ligne //
        if (str_starts_with($trimmed, '//')) {
            ++$cloc;
            continue;
        }

        // Commentaire en fin de ligne
        if (str_contains($trimmed, '//')) {
            ++$cloc;
        }
    }

    return ['loc' => $loc, 'cloc' => $cloc];
}

/**
 * Calcule la complexité cyclomatique (CC)
 * CC = 1 + nombre de points de décision.
 */
function cyclomaticComplexity(string $content): int
{
    // Retirer les commentaires et strings pour éviter les faux positifs
    $clean = preg_replace('|/\*.*?\*/|s', '', $content);
    $clean = preg_replace('|//.*$|m', '', $clean);
    $clean = preg_replace("/'.+?'/", "''", $clean);
    $clean = preg_replace('/".*?"/', '""', $clean);

    $cc = 1; // Base

    // Points de décision
    $patterns = [
        '/\bif\s*\(/',
        '/\belseif\s*\(/',
        '/\belse\s+if\s*\(/',
        '/\bwhile\s*\(/',
        '/\bfor\s*\(/',
        '/\bforeach\s*\(/',
        '/\bcase\s+/',
        '/\bcatch\s*\(/',
        '/\?\?/',
        '/\?\s*[^\x3e]/',
        '/&&/',
        '/\|\|/',
    ];

    foreach ($patterns as $pattern) {
        $cc += preg_match_all($pattern, $clean);
    }

    return $cc;
}

/**
 * Calcule le Volume de Halstead (HV)
 * HV = N * log2(n)
 * N = nombre total d'opérateurs + opérandes
 * n = nombre d'opérateurs uniques + opérandes uniques.
 */
function halsteadVolume(string $content): float
{
    // Retirer commentaires
    $clean = preg_replace('|/\*.*?\*/|s', '', $content);
    $clean = preg_replace('|//.*$|m', '', $clean);

    // Opérateurs PHP
    $operatorPatterns = [
        '=',
        '==',
        '===',
        '!=',
        '!==',
        '<',
        '>',
        '<=',
        '>=',
        '<=>',
        '+',
        '-',
        '*',
        '/',
        '%',
        '**',
        '.',
        '.',
        '&&',
        '||',
        '!',
        'and',
        'or',
        'not',
        '->',
        '::',
        '=>',
        '??',
        '?:',
        'new',
        'return',
        'if',
        'else',
        'elseif',
        'while',
        'for',
        'foreach',
        'switch',
        'case',
        'break',
        'continue',
        'throw',
        'try',
        'catch',
        'function',
        'class',
        'public',
        'private',
        'protected',
        'static',
    ];

    // Compter les tokens PHP
    $tokens = @token_get_all($content);
    $operators = [];
    $operands = [];

    foreach ($tokens as $token) {
        if (is_array($token)) {
            $type = $token[0];
            $value = $token[1];

            // Ignorer espaces, commentaires, open/close tags
            if (in_array($type, [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT, T_OPEN_TAG, T_CLOSE_TAG, T_INLINE_HTML])) {
                continue;
            }

            // Opérateurs = mots-clés du langage
            if (
                in_array($type, [
                    T_IF,
                    T_ELSE,
                    T_ELSEIF,
                    T_WHILE,
                    T_FOR,
                    T_FOREACH,
                    T_DO,
                    T_SWITCH,
                    T_CASE,
                    T_BREAK,
                    T_CONTINUE,
                    T_RETURN,
                    T_FUNCTION,
                    T_CLASS,
                    T_NEW,
                    T_THROW,
                    T_TRY,
                    T_CATCH,
                    T_PUBLIC,
                    T_PRIVATE,
                    T_PROTECTED,
                    T_STATIC,
                    T_FINAL,
                    T_EXTENDS,
                    T_IMPLEMENTS,
                    T_INTERFACE,
                    T_ABSTRACT,
                    T_ECHO,
                    T_PRINT,
                    T_ARRAY,
                    T_LIST,
                    T_BOOLEAN_AND,
                    T_BOOLEAN_OR,
                    T_LOGICAL_AND,
                    T_LOGICAL_OR,
                    T_IS_EQUAL,
                    T_IS_IDENTICAL,
                    T_IS_NOT_EQUAL,
                    T_IS_NOT_IDENTICAL,
                    T_IS_SMALLER_OR_EQUAL,
                    T_IS_GREATER_OR_EQUAL,
                    T_DOUBLE_ARROW,
                    T_OBJECT_OPERATOR,
                    T_NULLSAFE_OBJECT_OPERATOR,
                    T_COALESCE,
                ])
            ) {
                $operators[$value] = ($operators[$value] ?? 0) + 1;
            }
            // Opérandes = variables, constantes, strings, nombres
            elseif (
                in_array($type, [
                    T_VARIABLE,
                    T_STRING,
                    T_LNUMBER,
                    T_DNUMBER,
                    T_CONSTANT_ENCAPSED_STRING,
                    T_ENCAPSED_AND_WHITESPACE,
                ])
            ) {
                $operands[$value] = ($operands[$value] ?? 0) + 1;
            }
        } else {
            // Caractères simples : (, ), {, }, ;, =, +, -, etc.
            if (!in_array($token, ['(', ')', '{', '}', ';', ',', '[', ']'])) {
                $operators[$token] = ($operators[$token] ?? 0) + 1;
            }
        }
    }

    $n1 = count($operators);       // opérateurs uniques
    $n2 = count($operands);        // opérandes uniques
    $N1 = array_sum($operators);   // total opérateurs
    $N2 = array_sum($operands);    // total opérandes

    $N = $N1 + $N2;
    $n = $n1 + $n2;

    if ($n <= 1) {
        return 0;
    }

    return $N * log($n, 2);
}

/**
 * Calcule l'Index de Maintenabilité (MI)
 * MI = 171 - 5.2 * ln(HV) - 0.23 * CC - 16.2 * ln(LOC) + 50 * sin(sqrt(2.4 * CM)).
 */
function maintainabilityIndex(int $loc, int $cloc, int $cc, float $hv): array
{
    if (0 == $loc) {
        $loc = 1;
    }
    $cm = $cloc / $loc;

    $miWithoutComments = 171
        - 5.2 * ($hv > 0 ? log($hv) : 0)
        - 0.23 * $cc
        - 16.2 * log($loc);

    $commentWeight = 50 * sin(sqrt(2.4 * $cm));

    $mi = $miWithoutComments + $commentWeight;

    // Interprétation
    if ($mi > 85) {
        $interpretation = 'Très maintenable';
    } elseif ($mi >= 65) {
        $interpretation = 'Maintenable';
    } else {
        $interpretation = 'Difficilement maintenable';
    }

    return [
        'cm' => round($cm, 2),
        'mi' => round($mi, 2),
        'interpretation' => $interpretation,
    ];
}

/**
 * Détermine le composant à partir du chemin.
 */
function getComponent(string $path): string
{
    if (str_contains($path, 'Controller')) {
        return 'Controller';
    }
    if (str_contains($path, 'Entity')) {
        return 'Entity';
    }
    if (str_contains($path, 'Repository')) {
        return 'Repository';
    }
    if (str_contains($path, 'Command')) {
        return 'Command';
    }
    if (str_contains($path, 'Form')) {
        return 'Form';
    }
    if (str_contains($path, 'Enum')) {
        return 'Enum';
    }

    return 'Autre';
}

// === ANALYSE DES FICHIERS ===
echo "=== Analyse des métriques logicielles ===\n\n";

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($srcDir)
);

$results = [];

foreach ($files as $file) {
    if ('php' !== $file->getExtension()) {
        continue;
    }

    $path = $file->getRealPath();
    $filename = $file->getFilename();
    $content = file_get_contents($path);

    $lines = countLines($content);
    $cc = cyclomaticComplexity($content);
    $hv = halsteadVolume($content);
    $mi = maintainabilityIndex($lines['loc'], $lines['cloc'], $cc, $hv);

    $results[] = [
        'fichier' => $filename,
        'composant' => getComponent($path),
        'loc' => $lines['loc'],
        'cloc' => $lines['cloc'],
        'cc' => $cc,
        'hv' => round($hv, 2),
        'cm' => $mi['cm'],
        'mi' => $mi['mi'],
        'interpretation' => $mi['interpretation'],
    ];

    printf(
        "  %-35s LOC=%-4d CLOC=%-4d CC=%-3d HV=%-8.2f MI=%-7.2f %s\n",
        $filename,
        $lines['loc'],
        $lines['cloc'],
        $cc,
        $hv,
        $mi['mi'],
        $mi['interpretation']
    );
}

// Trier par MI croissant (les plus critiques en premier)
usort($results, fn ($a, $b) => $a['mi'] <=> $b['mi']);

// === GÉNÉRATION CSV ===
$fp = fopen($outputFile, 'w');

// En-tête MI
fputcsv($fp, ['Fichier', 'Composant', 'LOC', 'CLOC', 'CC', 'HV', 'CM', 'MI', 'Interprétation'], ';');

foreach ($results as $r) {
    fputcsv($fp, [
        $r['fichier'],
        $r['composant'],
        $r['loc'],
        $r['cloc'],
        $r['cc'],
        $r['hv'],
        $r['cm'],
        $r['mi'],
        $r['interpretation'],
    ], ';');
}

// Ligne vide de séparation
fputcsv($fp, [], ';');

// MI moyen
$avgMi = count($results) > 0 ? round(array_sum(array_column($results, 'mi')) / count($results), 2) : 0;
fputcsv($fp, ['MI moyen du projet', $avgMi, '', '', '', '', '', '', $avgMi > 85 ? 'Très maintenable' : ($avgMi >= 65 ? 'Maintenable' : 'Difficilement maintenable')], ';');

fclose($fp);

echo "\n=== Résumé ===\n";
echo "  MI moyen : $avgMi\n";
echo "\n  Rapport exporté dans : $outputFile\n";
