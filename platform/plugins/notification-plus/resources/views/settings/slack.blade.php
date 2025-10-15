<x-notification-plus::setting-form name="slack">
    <div class="mb-3 form-group">
        <label class="text-title-field">{{ trans('plugins/notification-plus::notification-plus.slack.settings.webhook_url') }}</label>
        <input type="text" name="{{ NotificationPlus::getSettingKey($name, 'webhook_url') }}" class="next-input" value="" placeholder="REDACTED_URL_PLACEHOLDER">
        {!! Form::helper(trans('plugins/notification-plus::notification-plus.slack.settings.webhook_url_instruction', ['link' => Html::link('https://t.me/BotFather', '@BotFather', ['target' => '_blank'])->toHtml()])) !!}
    </div>
</x-notification-plus::setting-form>
