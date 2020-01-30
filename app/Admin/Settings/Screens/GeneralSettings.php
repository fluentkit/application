<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\Fields\Email;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Password;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Screens\FormScreen;
use Illuminate\Http\Request;

final class GeneralSettings extends FormScreen
{
    public function __construct()
    {
        $this->setId('general');
        $this->setLabel('General Settings');

        $this->addField(
            (new Text('text1', 'Text Field', 'Text field description'))
                ->rules(['required'])
                ->disable()
        );
        $this->addField(
            (new Panel('panel1', 'Panel 1', 'Panel description.'))
                ->addField(
                    (new Text('text2', 'Text2 Field', 'Text2 field description'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Email('email1', 'Email1 Field', 'Email1 field description'))
                        ->rules(['required'])
                )
                ->addField(new Number('number1', 'Number1 Field', 'Number1 field description'))
                ->addField(new Password('password1', 'Password1 Field', 'Password1 field description'))
        );

        $this->addAction(
            (new SaveAction('save', 'Save Changes'))
                ->saveCallback([$this, 'save'])
        );
    }

    public function getAttributes(Request $request): array
    {
        return [
            'email1' => 'foo',
            'text1' => 'text field',
            'text2' => 'bar',
            'number1' => 10,
            'password1' => 'foobar',
        ];
    }

    public function save(Request $request)
    {
        //return Notification::info('hello');
    }
}
