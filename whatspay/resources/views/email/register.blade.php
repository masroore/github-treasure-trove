
@include('includes.header')

<!-- Content Area -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="center" valign="top">
         <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
               <td align="center" valign="top" bgcolor="#f6f6f6">
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                        <td height="50" colspan="2" align="left" valign="top" style="line-height:50px; font-size:50px;">&nbsp;</td>
                     </tr>
                     <tr>
                        <td width="100%" align="center" valign="top" >
                           <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td align="left" valign="top" width="65"><img src="https://www.whatspays.net/images/heading-line.png" width="50" alt="" style="margin-top: 15px;" /></td>
                                 <td align="left" valign="top" style="font-family: 'Poppins', sans-serif; color: #1B9AD6; font-size: 20px; font-weight: 300;">Hey {{ $name }} <span style="display: inline-block;">👋</span><br>
                                    <span style="color: #243F84; font-size: 24px; font-weight: 700; line-height: 40px;">Welcome</span>
                                 </td>
                              </tr>
                              <tr>
                                 <td height="15" colspan="2" align="left" valign="top" style="line-height:15px; font-size:15px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td align="left" valign="top" width="65">&nbsp;</td>
                                 <td align="left" valign="top">
                                    <h2 style="color: #000000; font-size: 20px; font-weight: 700; ">Thank you for registering on <strong>WhatsPays!</strong></h2>
                                    <p style="color: #000000; font-size: 16px; font-weight: 300;">The ultimate app on WhatsApp to shop, pay school fees or run your store online.<br>
                                    Kindly verify yourself using the button below or enter code <strong>{{ $activation_code }}</strong> to activate your account.</p>
                                 </td>
                                 <td align="left" valign="top" width="25">&nbsp;</td>
                              </tr>

                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td height="25" colspan="2" align="left" valign="top" style="line-height:25px; font-size:25px;">&nbsp;</td>
                     </tr>
                     <tr>
                        <td align="center" valign="top">
                           <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tbody>
                                 <tr>
                                    <td height="50" align="center" valign="middle" bgcolor="#46cd93" style="font-size:20px; color:#FFF; font-weight:bold; line-height:12px; text-transform:uppercase; -moz-border-radius: 30px; border-radius: 30px;" class="button-bg"><a href="{{ $link }}" style="text-decoration:none; color:#FFF;" title="Verify Now" target="_blank">Verify Now</a></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td height="50" colspan="2" align="left" valign="top" style="line-height:50px; font-size:50px;">&nbsp;</td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<!--/ Content Area -->

@include('includes.footer')