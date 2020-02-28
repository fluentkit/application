<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\Fields\Condition;
use FluentKit\Admin\UI\Fields\Email;
use FluentKit\Admin\UI\Fields\Group;
use FluentKit\Admin\UI\Fields\KeyValue;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Password;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Screens\FormScreen;
use Illuminate\Http\Request;

final class GeneralSettings extends FormScreen
{
    public function __construct()
    {
        $this->setId('general');
        $this->setLabel('General Settings');

        $this->addField(
            (new Panel('panel', 'Field Types', 'Panel fields can/should be used to group fields.'))
                ->addField(
                    (new Text('text', 'Text', 'Basic text field.'))
                        ->addCondition(
                            (new Condition())
                                ->when('number')
                                ->notEquals(11)
                                ->setDisabled()
                        )
                        ->addCondition(
                            (new Condition())
                                ->when('number')
                                ->contains(3)
                                ->setHidden()
                        )
                )
                ->addField(
                    (new Number('number', 'Number', 'Basic number field.'))
                        ->addCondition(
                            (new Condition())
                                ->when('text')
                                ->equals('foobar')
                                ->setDisabled()
                        )
                        ->addCondition(
                            (new Condition())
                                ->when('text')
                                ->equals('bazzer')
                                ->setHidden()
                        )
                )
                ->addField(new Password('password', 'Password', 'Basic number field.'))
                ->addField(
                    (new Email('email', 'Email', 'Basic email field.'))
                        ->addCondition(
                            (new Condition())
                                ->when('text')
                                ->equals('change email')
                                ->setValue('hi there! ive changed!')
                        )
                        ->addCondition(
                            (new Condition())
                                ->when('text')
                                ->equals('change email2')
                                ->setValue('hi there! ive changed twice!')
                        )
                )
                ->addField(
                    (new Group('group', 'Group', 'Group fields can be used to group similar fields.'))
                        ->addField(new Text('group-text', 'Text'))
                        ->addField(new Number('group-number', 'Number'))
                        ->addField(
                            (new Password('group-password', 'Password', 'Fields can also be stacked'))->layout('stacked')
                        )
                        ->addField(
                            (new Email('group-email', 'Email'))->layout('stacked')
                        )
                )
                ->addField(
                    (new KeyValue('key-value', 'Key Value', 'Key value fields can be used to enter json object values.'))
                        ->setKeyLabel('Custom Key Label')
                        ->setValueLabel('Custom Value Label')
                        ->setAddLabel('Custom Add New Text')
                        ->setValueField(Email::class)
                )
        );

        $this->addField(new Text('outside-text', 'Outside Text', 'Fields can also live outside of panels.'));

        $this->addField(
            (new Panel('panel-required', 'Field Validation', 'Fields can have their own validation rules.'))
                ->addField(
                    (new Text('required-text', 'Text', 'Basic text field.'))
                        ->rules(['required', 'string', 'min:10'])
                )
                ->addField(
                    (new Number('required-number', 'Number', 'Basic number field.'))
                        ->rules(['required', 'min:50', 'max:51'])
                )
                ->addField(
                    (new Password('required-password', 'Password', 'Basic number field.'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Email('required-email', 'Email', 'Basic email field.'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Group('required-group', 'Group', 'Group fields can be used to group similar fields.'))
                        ->addField(
                            (new Text('required-group-text', 'Text'))
                                ->rules(['required', 'ends_with:foo'])
                        )
                        ->addField(
                            (new Number('required-group-number', 'Number'))
                                ->rules(['required', 'max:2'])
                        )
                        ->addField(
                            (new Password('required-group-password', 'Password', 'Fields can also be stacked'))
                                ->layout('stacked')
                                ->rules(['required'])
                        )
                        ->addField(
                            (new Email('required-group-email', 'Email'))
                                ->layout('stacked')
                                ->rules(['required'])
                        )
                )
                ->addField(
                    (new KeyValue('required-key-value', 'Key Value', 'Key value fields can be used to enter json object values.'))
                        ->setKeyLabel('Custom Key Label')
                        ->setValueLabel('Custom Value Label')
                        ->setAddLabel('Custom Add New Text')
                        ->setValueField(Email::class)
                        ->rules(['required', 'starts_with:foo'])
                )
        );

        $this->addField(
            (new Panel('panel-disabled', 'Disabled Fields', 'Fields can be disabled, individually or at panel/group level.'))
                ->addField(
                    (new Text('disabled-text', 'Text', 'Basic text field.'))
                )
                ->addField(
                    (new Number('disabled-number', 'Number', 'Basic number field.'))
                )
                ->addField(
                    (new Password('disabled-password', 'Password', 'Basic number field.'))
                )
                ->addField(
                    (new Email('disabled-email', 'Email', 'Basic email field.'))
                )
                ->addField(
                    (new Group('disabled-group', 'Group', 'Group fields can be used to group similar fields.'))
                        ->addField(
                            (new Text('disabled-group-text', 'Text'))
                        )
                        ->addField(
                            (new Number('disabled-group-number', 'Number'))
                        )
                        ->addField(
                            (new Password('disabled-group-password', 'Password', 'Fields can also be stacked'))
                                ->layout('stacked')
                        )
                        ->addField(
                            (new Email('disabled-group-email', 'Email'))
                                ->layout('stacked')
                        )
                )
                ->addField(
                    (new KeyValue('disabled-key-value', 'Key Value', 'Key value fields can be used to enter json object values.'))
                        ->setKeyLabel('Custom Key Label')
                        ->setValueLabel('Custom Value Label')
                        ->setAddLabel('Custom Add New Text')
                        ->setValueField(Email::class)
                )
                ->disable(fn () => true)
        );

        $this->addField(
            (new Panel('panel-readonly', 'ReadOnly Fields', 'Fields can be readOnly, individually or at panel/group level.'))
                ->addField(
                    (new Text('readonly-text', 'Text', 'Basic text field.'))
                )
                ->addField(
                    (new Number('readonly-number', 'Number', 'Basic number field.'))
                )
                ->addField(
                    (new Password('readonly-password', 'Password', 'Basic number field.'))
                )
                ->addField(
                    (new Email('readonly-email', 'Email', 'Basic email field.'))
                )
                ->addField(
                    (new Group('readonly-group', 'Group', 'Group fields can be used to group similar fields.'))
                        ->addField(
                            (new Text('readonly-group-text', 'Text'))
                        )
                        ->addField(
                            (new Number('readonly-group-number', 'Number'))
                        )
                        ->addField(
                            (new Password('readonly-group-password', 'Password', 'Fields can also be stacked'))
                                ->layout('stacked')
                        )
                        ->addField(
                            (new Email('readonly-group-email', 'Email'))
                                ->layout('stacked')
                        )
                )
                ->addField(
                    (new KeyValue('readonly-key-value', 'Key Value', 'Key value fields can be used to enter json object values.'))
                        ->setKeyLabel('Custom Key Label')
                        ->setValueLabel('Custom Value Label')
                        ->setAddLabel('Custom Add New Text')
                        ->setValueField(Email::class)
                )
                ->readOnly(fn () => true)
        );

        $this->addAction(
            (new SaveAction('save', 'Save Changes'))
                ->callback([$this, 'save'])
        );
    }

    public function getAttributes(Request $request): array
    {
        return [
            'text' => 'text field',
            'number' => 10,
            'password' => 'foobar',
            'email' => 'email@example.com',
            'group-text' => 'text',
            'group-number' => 20,
            'group-password' => 'bazzer',
            'group-email' => 'email@example2.com',
            'key-value' => ['one' => 'two', 'three' => 'four'],
            'outside-text' => 'outside text field',
            'required-text' => 'text field',
            'required-number' => 10,
            'required-password' => 'foobar',
            'required-email' => 'email@example.com',
            'required-group-text' => 'text',
            'required-group-number' => 20,
            'required-group-password' => 'bazzer',
            'required-group-email' => 'email@example2.com',
            'required-key-value' => ['one' => 'two', 'three' => 'four'],
            'disabled-text' => 'text field',
            'disabled-number' => 10,
            'disabled-password' => 'foobar',
            'disabled-email' => 'email@example.com',
            'disabled-group-text' => 'text',
            'disabled-group-number' => 20,
            'disabled-group-password' => 'bazzer',
            'disabled-group-email' => 'email@example2.com',
            'disabled-key-value' => ['one' => 'two', 'three' => 'four'],
            'readonly-text' => 'text field',
            'readonly-number' => 10,
            'readonly-password' => 'foobar',
            'readonly-email' => 'email@example.com',
            'readonly-group-text' => 'text',
            'readonly-group-number' => 20,
            'readonly-group-password' => 'bazzer',
            'readonly-group-email' => 'email@example2.com',
            'readonly-key-value' => ['one' => 'two', 'three' => 'four'],
        ];
    }

    public function save(Request $request)
    {
        //return Notification::info('hello');
    }
}
