<?php

namespace Styde\Html\Tests;

use Styde\Html\FormModel;
use Styde\Html\FormModel\Field;
use Styde\Html\FormModel\FieldCollection;

class FieldCollectionTest extends TestCase
{
    /** @test */
    function check_if_the_field_collection_is_empty()
    {
        $form = app(TestFormModel::class);

        $this->assertTrue($form->fields->isEmpty());

        $form->text('first_name');

        $this->assertFalse($form->fields->isEmpty());
    }

    /** @test */
    function it_adds_and_gets_a_field()
    {
        $form = app(TestFormModel::class);

        $form->text('first_name');

        $this->assertInstanceOf(Field::class, $form->fields->first_name);
    }
    
    /** @test */
    function it_adds_a_number_field()
    {
        $form = app(TestFormModel::class);

        $form->number('pin');

        $this->assertInstanceOf(Field::class, $form->fields->pin);
        $this->assertSame('number', $form->fields->pin->type);
    }

    /** @test */
    function it_renders_the_field_collection()
    {
        $form = app(TestFormModel::class);

        $form->text('name')->label('Full name');
        $form->select('role')->options(['admin' => 'Admin' , 'user' => 'User']);

        $this->assertTemplateMatches('field-collection/fields', $form->renderFields());
    }

    /** @test */
    function it_can_add_basic_html_tags()
    {
        $form = app(TestFormModel::class);

        $tag = $form->tag('h3', 'Title', ['class' => 'red']);

        $this->assertHtmlEquals('<h3 class="red">Title</h3>', $tag);

        $tag = $form->tag('hr', ['class' => 'red']);

        $this->assertHtmlEquals('<hr class="red">', $tag);

        $this->assertCount(2, $form->fields->all());
    }
}
