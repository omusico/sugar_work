{*
 * Part of SugarTalk Asterisk module
 * © 2012 sugartalk.net | D1ma Z.
 *}

{capture name=getPhone assign=phone}{sugar_fetch object=$parentFieldArray key=$col}{/capture}
{assign var="phone_val_vis" value="^|^"|explode:$phone}

{*{sugar_phone value=$phone usa_format=$usa_format}*}

{php}
global $current_user;
$this->assign('asterisk_dial_buttons', $current_user->asterisk_dial_buttons);
{/php}
{sugar_phone value=$phone_val_vis[0] usa_format=$usa_format}

{if ($asterisk_dial_buttons == 1)}
	{if (!empty($phone))}
		<a href="index.php?module=Asterisk&action=OutboundCall&phone={$phone}" class="outboundCall" title="Создать вызов" style="text-decoration: none;">
			<img src="modules/Asterisk/img/call_active.gif" />
		</a>
	{/if}
{/if}
