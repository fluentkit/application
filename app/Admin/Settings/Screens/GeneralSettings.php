<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\FormScreen;
use Illuminate\Http\Request;

final class GeneralSettings extends FormScreen
{
    public const SCREEN_ID = 'general';

    protected int $priority = 10;

    protected string $label = 'General Settings';

    public function __construct()
    {
        $this->fields = [
            'panel1' => [
                'id' => 'panel1',
                'label' => 'Panel 1',
                'type' => 'panel',
                'description' => 'the description',
                'fields' => [
                    'email1' => [
                        'id' => 'email1',
                        'label' => 'Email Address',
                        'required' => true,
                        'type' => 'email',
                        'description' => 'the description',
                    ],
                    'text1' => [
                        'id' => 'text1',
                        'label' => 'Text',
                        'required' => false,
                        'type' => 'text',
                        'description' => 'the description',
                    ],
                ],
            ],
            'text2' => [
                'id' => 'text2',
                'label' => 'Text 2',
                'required' => true,
                'type' => 'text',
                'description' => 'the description',
            ],
            'panel2' => [
                'id' => 'panel2',
                'label' => 'Panel 2',
                'type' => 'panel',
                'description' => 'the description',
                'fields' => [
                    'email3' => [
                        'id' => 'email3',
                        'label' => 'Email Address',
                        'required' => false,
                        'type' => 'email',
                        'description' => 'the description',
                    ],
                    'text3' => [
                        'id' => 'text3',
                        'label' => 'Text',
                        'required' => true,
                        'type' => 'text',
                        'description' => 'the description',
                    ],
                ],
            ],
        ];
    }

    public function getAttributes(Request $request): array
    {
        return [
            'data' => [
                'attributes' => [
                    'panel1' => [
                        'email1' => 'foo',
                        'text1' => 'text field'
                    ],
                    'text2' => 'bar',
                    'panel2' => [
                        'email3' => 'foo',
                        'text3' => 'text field'
                    ],
                ]
            ]
        ];
    }

    public function saveAttributes(Request $request)
    {
        return [
            'data' => [
                'request' => $request->all(),
                'message' => 'Settings Updated!'
            ],
        ];
    }
}
