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

{literal}
    <script type="text/javascript">
            var status =  $("#status");
            showStatus( status );
            status.change(function(){ showStatus( $(this) ) });

            function showStatus( status )
            {
                if( status.val() == "Held" || status.val() == "Not Held" ) {
                    hideStatus( false );
                } else {
                    hideStatus( true );
                }
            }

            function hideStatus( hide )
            {
                var show_results = $("#show_results");
                if( hide === true ){
                   show_results.css( "display", "none" );
                   show_results.parent().prev().css( "display", "none" );
                   show_results.replaceWith("<div id=\"show_results\">"+show_results.val()+"</div>");
                   //removeFromValidate("CalendarEditView", show_results[0].name);
                } else {
                   show_results.css( "display", "" );
                   show_results.parent().prev().css( "display", "" );
                   show_results.replaceWith("<textarea name=\"show_results\" cols=\"60\" rows=\"8\" id=\"show_results\">"+show_results.val()+"</textarea>");
                   //addToValidate("CalendarEditView", show_results[0].name, "text", true, "Результат");
                }

            }

    </script>
{/literal}