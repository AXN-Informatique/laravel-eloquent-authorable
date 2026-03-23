<?php

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector;
use RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector;
use RectorLaravel\Rector\MethodCall\ReverseConditionableMethodCallRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withImportNames()
    ->withParallel(
        timeoutSeconds: 320,
        maxNumberOfProcess: 16,
        jobSize: 20,
    )
    ->withCache(
        cacheClass: FileCacheStorage::class,
        cacheDirectory: __DIR__.'/.rector_cache',
    )
    ->withPaths([
        __DIR__.'/src',
    ])

    // Up from PHP X.x to 8.4
    ->withPhpSets()

    // only PHP 8.4
    // ->withPhpSets(php84: true)

    ->withSkip([
        // Cet attribut natif PHP n'est pas très utile ;
        // mieux vaux se baser sur de l'analyse statique
        // En plus, lors de la rédaction de ce message,
        // la règle fonctionne mal, elle est buguée...
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ])
    ->withRules([
        EloquentWhereRelationTypeHintingParameterRector::class,
        EloquentWhereTypeHintClosureParameterRector::class,
        OptionalToNullsafeOperatorRector::class,
        RemoveDumpDataDeadCodeRector::class,
        RedirectBackToBackHelperRector::class,
        ReplaceServiceContainerCallArgRector::class,
        ReverseConditionableMethodCallRector::class,
        RouteActionCallableRector::class,
        UnifyModelDatesWithCastsRector::class,
        ValidationRuleArrayStringValueToArrayRector::class,
    ])
    ->withSets([
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
    ])
    ->withPreparedSets(
        // Supprimer le code mort (variables, méthodes, classes inutilisées)
        deadCode: true,

        // Améliorer la qualité du code (simplifications, bonnes pratiques)
        codeQuality: true,

        // Uniformiser le style (espaces, syntaxe, conventions)
        codingStyle: true,

        // Ajouter/corriger les type hints (paramètres, retours, propriétés)
        typeDeclarations: true,

        // Convertir les docblocks @var/@param/@return en type hints natifs
        typeDeclarationDocblocks: false,

        // Réduire la visibilité au minimum (public → private/protected)
        privatization: false,

        // Renommer variables/méthodes selon les conventions (camelCase, etc.)
        naming: false,

        // Simplifier les vérifications instanceof
        instanceOf: true,

        // Transformer en early return (réduire l'imbrication)
        earlyReturn: true,

        // Moderniser l'usage de Carbon (méthodes dépréciées, etc.)
        carbon: true,

        // Set de règles internes Rector (refactoring opinionné, fourre-tout)
        rectorPreset: false,

        // Améliorer le code des tests PHPUnit
        phpunitCodeQuality: false,

        // Améliorer le code lié à Doctrine ORM
        doctrineCodeQuality: false,

        // Améliorer le code lié à Symfony
        symfonyCodeQuality: false,

        // Moderniser les fichiers de config Symfony (YAML → PHP)
        symfonyConfigs: false,
    );
