<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Image;

/**
 * @extends BaseTestCase<Image,\Filament\Forms\Components\FileUpload>
 */
class ImageTest extends BaseTestCase
{
    protected static string $fieldTypeClass = Image::class;

    /** @test */
    public function it_can_apply_config()
    {
        $field = $this->initializeFormComponentAndVerify(fn (Image $image)   => $image);

        $this->assertEquals(['image/*'], $field->getAcceptedFileTypes());
    }
}