<?php

require_once __DIR__ . '/vendor/autoload.php';

use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Faker\Factory;

$faker = Factory::create();
$faker->addProvider(new FakerProvider($faker));

$files = [
    'introduction.md',

    'getting-started' => [
        'quick-start.md',
        'installation.md',
        'configuration.md',
        'usage.md',
    ],

    'advanced' => [
        'customization.md',
        'api.md',
    ],

    'examples' => [
        'example1.md',
        'example2.md',
    ],

    'references.md',
    'conclusion.md',
    'license.md',
];

$index = 0;

foreach ($files as $path => $file)
{
    $frontmatter = "---\npriority: {$index}\n---\n\n";

    if (is_array($file))
    {
        $path = __DIR__ . '/docs/' . $path;
        $metaPath = $path . '/_meta.md';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        file_put_contents($metaPath, $frontmatter);

        foreach ($file as $i => $subfile)
        {
            $subfileFrontmatter = "---\npriority: {$i}\n---\n\n";

            file_put_contents($path . '/' . $subfile, $subfileFrontmatter . $faker->markdown());
        }
    }
    else
    {
        $file = __DIR__ . '/docs/' . $file;

        file_put_contents($file, $frontmatter . $faker->markdown());
    }

    $index++;
}
