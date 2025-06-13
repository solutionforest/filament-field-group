<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\FileUpload;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\File as FileUploadConfig;

/**
 * @extends BaseTestCase<FileUploadConfig,FileUpload>
 */
class FileTest extends BaseTestCase
{
    protected static string $fieldTypeClass = FileUploadConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $accept = ['image/*'];
        $maxFileSize = 1024;
        $maxFiles = 1;

        $field = $this->initializeFormComponentAndVerify(function (FileUploadConfig $file) use ($accept, $maxFileSize, $maxFiles) {
            $file->acceptedFileTypes = $accept;
            $file->sizeLimit['max'] = $maxFileSize;
            $file->fileLimit['max'] = $maxFiles;

            return $file;
        });

        $this->assertEquals($accept, $field->getAcceptedFileTypes());
        $this->assertEquals($maxFileSize, $field->getMaxSize());
        $this->assertEquals($maxFiles, $field->getMaxFiles());
    }
}
