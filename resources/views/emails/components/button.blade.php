 @if (isset($btn_url))
    <!--start part => 4 -->
    <tbody>
      <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;">
            <tbody>
              <tr>
                <td align="center" bgcolor="#0043DD" role="presentation" style="border:none;border-radius:24px;cursor:auto;height:48px;mso-padding-alt:10px 25px;background:#6A24FF;" valign="middle">
                  <a href="{{$btn_url}}" style="display:inline-block;background:#0043DD;color:#ffffff;font-family: 'Verdana', sans-serif;font-size:16px;font-weight:500;line-height:19px;letter-spacing:0.015em;margin:0;text-decoration:none;text-transform:none;padding:10px 25px;mso-padding-alt:0px;border-radius:24px;" target="_blank">  {{$btn_text}} </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>

    <tr>
      <td align="left" class="title" style="font-size:0px;padding:10px 25px;word-break:break-word;">
        <div style="text-align: left; color: #66667D; font-family: 'Verdana', sans-serif; font-weight: 400; font-size: 16px; line-height: 26px; letter-spacing: 0.015em;">or,<br> open link in browser: <a href="{{$btn_url}}">{{$btn_url}}</a></div>
      </td>
    </tr>
  </tbody>
   <!--end part => 4 -->
 @endif
