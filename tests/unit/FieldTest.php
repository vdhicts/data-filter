<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Exceptions;
use Vdhicts\Dicms\Filter\Field;

class FieldTest extends TestCase
{
    public function testFilterField()
    {
        $this->assertTrue(class_exists(Field::class));

        $fieldKey = 'manufacturer';
        $fieldValue = 1;
        $fieldApproval = Field::APPROVAL_ACCEPT;
        $field = new Field($fieldKey, $fieldValue, $fieldApproval);

        $this->assertInstanceOf(Field::class, $field);
        $this->assertSame($fieldKey, $field->getOption());
        $this->assertSame($fieldValue, $field->getValue());
        $this->assertSame($fieldApproval, $field->getApproval());

        $fieldArray = $field->toArray();

        $this->assertTrue(is_array($fieldArray));
        $this->assertArrayHasKey('option', $fieldArray);
        $this->assertSame($fieldKey, $fieldArray['option']);
        $this->assertArrayHasKey('value', $fieldArray);
        $this->assertSame($fieldValue, $fieldArray['value']);
        $this->assertArrayHasKey('approval', $fieldArray);
        $this->assertSame($fieldApproval, $fieldArray['approval']);
    }

    public function testFilterFieldInvalidApproval()
    {
        $this->expectException(Exceptions\InvalidApproval::class);

        new Field('test', 1, 999);
    }
}
