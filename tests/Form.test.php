<?php
use Bootstrapper\Form;
use Bootstrapper\Button;

class FormTest extends BootstrapperWrapper
{
    public function types()
    {
        return array(
            array(
                'search_open', 
                '<form class="foo form-search" data-foo="bar" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'search_open_secure',
                '<form class="foo form-search" data-foo="bar" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'search_open_for_files',
                '<form class="foo form-search" data-foo="bar" enctype="multipart/form-data" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'search_open_secure_for_files',
                '<form class="foo form-search" data-foo="bar" enctype="multipart/form-data" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'inline_open',
                '<form class="foo form-inline" data-foo="bar" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'inline_open_secure',
                '<form class="foo form-inline" data-foo="bar" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'inline_open_for_files',
                '<form class="foo form-inline" data-foo="bar" enctype="multipart/form-data" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'inline_open_secure_for_files',
                '<form class="foo form-inline" data-foo="bar" enctype="multipart/form-data" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'horizontal_open',
                '<form class="foo form-horizontal" data-foo="bar" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'horizontal_open_secure',
                '<form class="foo form-horizontal" data-foo="bar" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'horizontal_open_for_files',
                '<form class="foo form-horizontal" data-foo="bar" enctype="multipart/form-data" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'horizontal_open_secure_for_files',
                '<form class="foo form-horizontal" data-foo="bar" enctype="multipart/form-data" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'vertical_open',
                '<form class="foo" data-foo="bar" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'vertical_open_secure',
                '<form class="foo" data-foo="bar" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'vertical_open_for_files',
                '<form class="foo" data-foo="bar" enctype="multipart/form-data" method="POST" action="http://:/index.php/login" accept-charset="UTF-8">'
                ),
            array(
                'vertical_open_secure_for_files',
                '<form class="foo" data-foo="bar" enctype="multipart/form-data" method="POST" action="https://:/index.php/login" accept-charset="UTF-8">'
                )
        );
    }

    /**
     * @dataProvider types
     */
    public function testFormOpen($type, $exepcted)
    {
        $form = Form::$type('login', 'POST', $this->testAttributes);
        $this->assertEquals($exepcted, $form);
    }

    public function testInlineHelp()
    {
        $exepcted = '<span class="foo help-inline" data-foo="bar">foobar</span>';
        $html = Form::inline_help('foobar', $this->testAttributes);
        $this->assertEquals($exepcted, $html);
    }
    
    public function testBlockHelp()
    {
        $exepcted = '<p class="foo help-block" data-foo="bar">foobar</p>';
        $html = Form::block_help('foobar', $this->testAttributes);
        $this->assertEquals($exepcted, $html);
    }

    public function displaytypes()
    {
        return array(
            array(Form::NORMAL),
            array(Form::WARNING),
            array(Form::ERROR),
            array(Form::SUCCESS),
        );
    }

    /**
     * @dataProvider displaytypes
     */
    public function testControlGroup($displaytype)
    {
        $class = $displaytype;

        if($displaytype != ''){
            $class = ' '.$displaytype;
        }

        $matcher = array(
            'tag' => 'div',
            'attributes' => array('class' => 'control-group'.$class),
            'child' => array(
                'tag' => 'label',
                'attributes' => array('class' => 'control-label', 'for' => 'inputfoo'),
                'content' => 'foo',
            ),
            'descendant' => array(
                'tag' => 'div',
                'attributes' => array('class' => 'controls'),
                'child' => array(
                    'tag' => 'input',
                    'attributes' => array('type' => 'text', 'name' => 'inputfoo', 'id' => 'inputfoo'),
                )
            ),
        );

        $html = Form::control_group(
                    Form::label('inputfoo', 'foo'),
                    Form::text('inputfoo'), 
                    $displaytype
                );

        $this->assertTag($matcher, $html);
    }

    /**
     * @dataProvider displaytypes
     */
    public function testControlGroupFull($displaytype)
    {
        $class = $displaytype;

        if($displaytype != ''){
            $class = ' '.$displaytype;
        }

        // Had to match label and go up to the parent
        // than back down to get the other elements. Odd but can't 
        // figure out how to find 3 different child elements
        $matcher = array(
            'tag' => 'div',
            'attributes' => array('class' => 'controls'),
            'child' => array(
                'tag' => 'input',
                'attributes' => array('type' => 'text', 'name' => 'inputfoo', 'id' => 'inputfoo'),
            ),
            'parent' => array(
                'tag' => 'div',
                'attributes' => array('class' => 'control-group'.$class),
                'child' => array(
                    'tag' => 'label',
                    'attributes' => array('class' => 'control-label', 'for' => 'inputfoo'),
                    'content' => 'foo',
                ),
                'descendant' => array(
                    'tag' => 'div',
                    'attributes' => array('class' => 'controls'),
                    'child' => array(
                        'tag' => 'input',
                        'attributes' => array('type' => 'text', 'name' => 'inputfoo', 'id' => 'inputfoo'),
                    )
                ),
            ),
        );

        $html = Form::control_group(
                    Form::label('inputfoo', 'foo'),
                    Form::text('inputfoo'), 
                    $displaytype, 
                    Form::block_help('You foobared that!')
                );

        $this->assertTag($matcher, $html);
    }

    private function getLablledMatcher($type, $value, $full = false){
        $matcher = array(
            'tag' => 'label',
            'attributes' => array('class' => $type),
            'content' => 'foo',
            'child' => array(
                'tag' => 'input',
                'attributes' => array('type' => $type, 'name' => 'foo', 'value' => $value),
            ),
        );

        if($full) {
            $matcher['child']['attributes']['class'] = 'foo';
            $matcher['child']['attributes']['data-foo'] = 'bar';
            $matcher['child']['attributes']['checked'] = 'checked';
        }

        return $matcher;
    }

    public function testLabelledCheckboxMin() 
    {
        $html = Form::labelled_checkbox('foo', 'foo');
        $matcher = $this->getLablledMatcher('checkbox', 1);
        $this->assertTag($matcher, $html);
    }

    public function testLabelledCheckboxFull() 
    {
        $html = Form::labelled_checkbox('foo', 'foo', 'bar', true, $this->testAttributes);
        $matcher = $this->getLablledMatcher('checkbox', 'bar', true);
        $this->assertTag($matcher, $html);
    }

    public function testInlineLabelledCheckboxMin() 
    {
        $html = Form::inline_labelled_checkbox('foo', 'foo');
        $matcher = $this->getLablledMatcher('checkbox', 1);
        $matcher['attributes']['class'] .= ' inline';
        $this->assertTag($matcher, $html);
    }

    public function testInlineLabelledCheckboxFull() 
    {
        $html = Form::inline_labelled_checkbox('foo', 'foo', 'bar', true, $this->testAttributes);
        $matcher = $this->getLablledMatcher('checkbox', 'bar', true);
        $matcher['attributes']['class'] .= ' inline';
        $this->assertTag($matcher, $html);
    }

    public function testLabelledRadioMin() 
    {
        $html = Form::labelled_radio('foo', 'foo');
        $matcher = $this->getLablledMatcher('radio', 1);
        $this->assertTag($matcher, $html);
    }

    public function testLabelledRadioFull() 
    {
        $html = Form::labelled_radio('foo', 'foo', 'bar', true, $this->testAttributes);
        $matcher = $this->getLablledMatcher('radio', 'bar', true);
        $this->assertTag($matcher, $html);
    }

    public function testInlineLabelledRadioMin() 
    {
        $html = Form::inline_labelled_radio('foo', 'foo');
        $matcher = $this->getLablledMatcher('radio', 1);
        $matcher['attributes']['class'] .= ' inline';
        $this->assertTag($matcher, $html);
    }

    public function testInlineLabelledRadioFull() 
    {
        $html = Form::inline_labelled_radio('foo', 'foo', 'bar', true, $this->testAttributes);
        $matcher = $this->getLablledMatcher('radio', 'bar', true);
        $matcher['attributes']['class'] .= ' inline';
        $this->assertTag($matcher, $html);
    }

    public function testMultiSelectMin()
    {
        $html = Form::multiselect('multiSelect', array('1', '2', '3', '4', '5'));

        $matcher = array(
            'tag' => 'select',
            'attributes' => array('multiple' => 'multiple', 'name' => 'multiSelect'),
            'children' => array(
                'count' => 5,
                'only' => array(
                    'tag' => 'option'
                ),
            ),
        );

        $this->assertTag($matcher, $html);
    }

    public function testMultiSelectFull()
    {
        $html = Form::multiselect('multiSelect', array('1', '2', '3', '4', '5'), '3', $this->testAttributes);

        $matcher = array(
            'tag' => 'select',
            'attributes' => array('multiple' => 'multiple', 'name' => 'multiSelect'),
            'children' => array(
                'count' => 5,
                'only' => array(
                    'tag' => 'option'
                ),
            ),
            'child' => array(
                'tag' => 'option',
                'attributes' => array('value' => 3, 'selected' => 'selected'),
            )
        );

        $this->assertTag($matcher, $html);
    }

    public function testUneditable()
    {
        $html = Form::uneditable('foo', $this->testAttributes);
        $expected = '<span class="foo uneditable-input" data-foo="bar">foo</span>';

        $this->assertEquals($expected, $html);
    }

    public function testFile()
    {
        $html = Form::file('foo', $this->testAttributes);
        $expected = '<input class="foo input-file" data-foo="bar" type="file" name="foo">';

        $this->assertEquals($expected, $html);
    }

    public function testSearchBox()
    {
        $html = Form::search_box('foo', 'bar', $this->testAttributes);
        $expected = '<input class="foo search-query" data-foo="bar" type="text" name="foo" value="bar">';

        $this->assertEquals($expected, $html);
    }

    public function testActionBar()
    {
        $html = Form::actions(array(Button::primary_submit('Save changes'), Form::button('Cancel')));

        $matcher = array(
            'tag' => 'div',
            'attributes' => array('class' => 'form-actions'),
            'child' => array(
                'tag' => 'button',
                'attributes' => array('class' => 'btn-primary btn', 'type' => 'submit'),
                'content' => 'Save changes',
            ),
            'descendant' => array(
                'tag' => 'button',
                'attributes' => array('class' => 'btn', 'type' => 'button'),
                'content' => 'Cancel',
            ),
        );

        $this->assertTag($matcher, $html);
    }

    public function testPrepend()
    {
        $html = Form::prepend(Form::text('inputfoo'), '$');

        $matcher = array(
            'tag' => 'div',
            'attributes' => array('class' => 'input-prepend'),
            'child' => array(
                'tag' => 'span',
                'attributes' => array('class' => 'add-on'),
                'content' => '$',
            ),
            'descendant' => array(
                'tag' => 'input',
                'attributes' => array('type' => 'text', 'name' => 'inputfoo', 'id' => 'inputfoo'),
            ),
        );

        $this->assertTag($matcher, $html);
    }

    public function testAppend()
    {
        $html = Form::append(Form::text('inputfoo'), '$');
        $expected = '<div class="input-append"><input type="text" name="inputfoo" id="inputfoo"><span class="add-on">$</span></div>';

        $matcher = array(
            'tag' => 'div',
            'attributes' => array('class' => 'input-append'),
            'child' => array(
                'tag' => 'span',
                'attributes' => array('class' => 'add-on'),
                'content' => '$',
            ),
            'descendant' => array(
                'tag' => 'input',
                'attributes' => array('type' => 'text', 'name' => 'inputfoo', 'id' => 'inputfoo'),
            ),
        );

        $this->assertTag($matcher, $html);
    }

    public function testPrependAppend()
    {
        $html = Form::prepend_append(Form::text('inputfoo'), '$', '.00');

        $matcher = array(
            'tag' => 'input',
            'attributes' => array('type' => 'text', 'name' => 'inputfoo', 'id' => 'inputfoo'),
            'parent' => array(
                'tag' => 'div',
                'attributes' => array('class' => 'input-append'),
                'child' => array(
                    'tag' => 'span',
                    'attributes' => array('class' => 'add-on'),
                    'content' => '$',
                ),
                'descendant' => array(
                    'tag' => 'span',
                    'attributes' => array('class' => 'add-on'),
                    'content' => '.00',
                ),
            ),
        );

        $this->assertTag($matcher, $html);
    }
}