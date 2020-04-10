<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Password;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Screens\SettingScreen;

final class DiskSettings extends SettingScreen
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('filesystems');
        $this->setLabel('Disk Settings');
        $this->disable('setting.filesystems.viewAny');

        $this->addField(
            (new Panel('s3', 'Cloud Disk Configuration', 'To enable your cloud disk please ensure the details below are correctly entered.'))
                ->addField((new Checkbox('cloud_enabled', 'Enable Cloud Disk'))->setMeta('checkbox.label', 'Enabled'))
                ->addField((new Text('disks.s3.key', 'AWS Access Key'))->rules(['required_if:cloud_enabled,true']))
                ->addField((new Password('disks.s3.secret', 'AWS Secret Access Key'))->rules(['required_if:cloud_enabled,true']))
                ->addField(
                    (new Select('disks.s3.region', 'AWS Region'))
                        ->options([
                            [ 'id' => 'us-east-2', 'label' => 'US East (Ohio)' ],
                            [ 'id' => 'us-east-1', 'label' => 'US East (N. Virginia)' ],
                            [ 'id' => 'us-west-1', 'label' => 'US West (N. California)' ],
                            [ 'id' => 'us-west-2', 'label' => 'US West (Oregon)' ],
                            [ 'id' => 'ap-east-1', 'label' => 'Asia Pacific (Hong Kong)' ],
                            [ 'id' => 'ap-south-1', 'label' => 'Asia Pacific (Mumbai)' ],
                            [ 'id' => 'ap-northeast-3', 'label' => 'Asia Pacific (Osaka-Local)' ],
                            [ 'id' => 'ap-northeast-2', 'label' => 'Asia Pacific (Seoul)' ],
                            [ 'id' => 'ap-southeast-1', 'label' => 'Asia Pacific (Singapore)' ],
                            [ 'id' => 'ap-southeast-2', 'label' => 'Asia Pacific (Sydney)' ],
                            [ 'id' => 'ap-northeast-1', 'label' => 'Asia Pacific (Tokyo)' ],
                            [ 'id' => 'ca-central-1', 'label' => 'Canada (Central)' ],
                            [ 'id' => 'cn-north-1', 'label' => 'China (Beijing)' ],
                            [ 'id' => 'cn-northwest-1', 'label' => 'China (Ningxia)' ],
                            [ 'id' => 'eu-central-1', 'label' => 'Europe (Frankfurt)' ],
                            [ 'id' => 'eu-west-1', 'label' => 'Europe (Ireland)' ],
                            [ 'id' => 'eu-west-2', 'label' => 'Europe (London)' ],
                            [ 'id' => 'eu-west-3', 'label' => 'Europe (Paris)' ],
                            [ 'id' => 'eu-north-1', 'label' => 'Europe (Stockholm)' ],
                            [ 'id' => 'sa-east-1', 'label' => 'South America (São Paulo)' ],
                            [ 'id' => 'me-south-1', 'label' => 'Middle East (Bahrain)' ],
                        ])
                        ->rules(['required_if:cloud_enabled,true'])
                )
                ->addField((new Text('disks.s3.bucket', 'AWS Bucket'))->rules(['required_if:cloud_enabled,true']))
                ->addField((new Text('disks.s3.url', 'AWS URL'))->rules(['required_if:cloud_enabled,true']))
        );
    }
}
