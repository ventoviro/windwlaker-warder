<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Warder\Admin\Form\User;

use Lyrasoft\Unidev\Field\SingleImageDragField;
use Lyrasoft\Warder\Admin\Field\User\UserGroupField;
use Lyrasoft\Warder\Helper\AvatarUploadHelper;
use Lyrasoft\Warder\Helper\WarderHelper;
use Phoenix\Form\PhoenixFieldTrait;
use Windwalker\Core\Form\AbstractFieldDefinition;
use Windwalker\Form\Form;
use Windwalker\Validator\Rule\EmailValidator;

/**
 * The UserEditDefinition class.
 *
 * @since  1.0
 */
class EditDefinition extends AbstractFieldDefinition
{
    use PhoenixFieldTrait;

    /**
     * Define the form fields.
     *
     * @param Form $form The Windwalker form object.
     *
     * @return  void
     * @throws \InvalidArgumentException
     */
    public function doDefine(Form $form)
    {
        $warder = WarderHelper::getPackage();

        $loginName  = WarderHelper::getLoginName();
        $langPrefix = $warder->get('admin.language.prefix', 'warder.');

        // Basic fieldset
        $form->fieldset('basic', function (Form $form) use ($loginName, $langPrefix) {
            // Name
            $this->text('name')
                ->label(__($langPrefix . 'user.field.name'))
                ->addFilter('trim')
                ->required(true);

            if ($loginName !== 'email') {
                // Name
                $this->text($loginName)
                    ->label(__($langPrefix . 'user.field.' . $loginName))
                    ->addFilter('trim')
                    ->autocomplete('new-password')
                    ->required(true);
            }

            // Email
            $this->email('email')
                ->label(__($langPrefix . 'user.field.email'))
                ->addFilter('trim')
                ->addValidator(EmailValidator::class)
                ->addClass('validate-email')
                ->autocomplete('new-password')
                ->required();

            // Password
            $this->password('password')
                ->label(__($langPrefix . 'user.field.password'))
                ->attr('data-role', 'password')
                ->autocomplete('new-password');

            $this->password('password2')
                ->label(__($langPrefix . 'user.field.password.confirm'))
                ->attr('data-validate', 'password-confirm')
                ->attr('data-confirm-target', '[data-role=password]')
                ->attr('data-custom-error-message', __('warder.forget.reset.message.password.not.match'))
                ->autocomplete('new-password');
        });

        // Created fieldset
        $form->fieldset('created', function (Form $form) use ($langPrefix) {
            if (class_exists(SingleImageDragField::class)) {
                // Avatar
                $this->add('avatar', new SingleImageDragField())
                    ->label(__($langPrefix . 'user.field.avatar'))
                    ->set('force_v1', true)
                    ->set('default_image', AvatarUploadHelper::getDefaultImage());
            }

            // Group
            $this->add('group', UserGroupField::class)
                ->label(__($langPrefix . 'user.field.group'))
                ->class('has-select2')
                ->required(true);

            // Blocked
            $this->switch('blocked')
                ->label(__($langPrefix . 'user.field.blocked'))
                ->class('')
                ->circle(true)
                ->color('danger')
                ->defaultValue(0);

            // Receive Mail
            $this->switch('receive_mail')
                ->label(__($langPrefix . 'user.field.receive.mail'))
                ->description(__($langPrefix . 'user.field.receive.mail.desc'))
                ->class('')
                ->circle(true)
                ->color('primary')
                ->defaultValue(0);

            // ID
            $this->text('id')
                ->label(__($langPrefix . 'user.field.id'))
                ->set('plain-text', true)
                ->readonly(true);

            // Registered
            $this->calendar('registered')
                ->label(__($langPrefix . 'user.field.registered'))
                ->set('plain-text', true)
                ->disabled(true);

            // Last Login
            $this->calendar('last_login')
                ->label(__($langPrefix . 'user.field.last.login'))
                ->set('plain-text', true)
                ->disabled();
        });
    }
}
