{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html {$langHeader}>
<head>
<link rel="SHORTCUT ICON" href="{$FAVICON_URL}">
<link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset={$APP.LBL_CHARSET}">
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<input type="hidden" value="{$smarty.request.module}" />
<title>{$APP.LBL_BROWSER_TITLE}</title>
{$SUGAR_CSS}
{$SUGAR_JS}

{literal}
<style  language="css" type="text/css">
#{/literal}{$smarty.request.module}{literal}_detailview_tabs
{
    /*background-color: #fff;*/
    border: 1px solid;
    border-radius: 2px;
    box-shadow: 0px 0px 7px grey;
    border-color: #3a7c98 !important;
    background-color: #fff;
    padding:10px;
    min-width: 1160px;
}
</style>
{/literal}


{if $smarty.request.module != "Contacts" && $smarty.request.module != "Accounts"}
{literal}
<style language="css" type="text/css" >
.detail.view.detail508.expanded table
{
    /*width: 100px;*/
    table-layout: fixed;
    /*border: 1px solid;*/
}
.detail.view.detail508 table
{
    /*width: 100px;*/
    table-layout: fixed;
    /*border: 1px solid;*/
}
.edit.view.edit508.expanded table
{
    /*width: 100px;*/
    border: 1px solid;
    table-layout: fixed;
}
</style>{/literal}
{/if}

{if $smarty.request.module == "Campaigns" && $smarty.request.action != "DetailView"}
{literal}
<style language="css" type="text/css" >
.detail.view table
{
    table-layout: fixed;
    background-color: #f5f5f5;
    border: 1px solid #3A7C98;
    overflow: visible;
    text-align: left;
    box-shadow: 0 0 7px grey;
}

.detail.view table tr td[scope="row"]
{
   text-align: left;
}
</style>{/literal}
{/if}

{literal}
<script type="text/javascript">

SUGAR.themes.theme_name      = '{/literal}{$THEME}{literal}';
SUGAR.themes.theme_ie6compat = {/literal}{$THEME_IE6COMPAT}{literal};
SUGAR.themes.hide_image      = '{/literal}{sugar_getimagepath file="hide.gif"}{literal}';
SUGAR.themes.show_image      = '{/literal}{sugar_getimagepath file="show.gif"}{literal}';
SUGAR.themes.loading_image      = '{/literal}{sugar_getimagepath file="img_loading.gif"}{literal}';
SUGAR.themes.allThemes       = eval({/literal}{$allThemes}{literal});
if ( YAHOO.env.ua )
    UA = YAHOO.env.ua;

</script>
{/literal}
<script type="text/javascript" src='{sugar_getjspath file="cache/include/javascript/sugar_field_grp.js"}'></script>

</head>