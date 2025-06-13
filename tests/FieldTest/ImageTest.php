<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\FileUpload;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Image as ImageUploadConfig;

/**
 * @extends BaseTestCase<ImageUploadConfig,FileUpload>
 */
class ImageTest extends BaseTestCase
{
    protected static string $fieldTypeClass = ImageUploadConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $field = $this->initializeFormComponentAndVerify(fn (ImageUploadConfig $image) => $image);

        $this->assertEquals(['image/*'], $field->getAcceptedFileTypes());
    }
}
