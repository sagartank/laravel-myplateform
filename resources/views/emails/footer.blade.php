</tr>
<tr>
  <p style="padding-top: 32px;">Atentamente,</p>
  <p style="font-weight: 600;padding-top:3px;">MIPO</p>
</tr>
</table>
</tr>
<tr>
  @php
    $img_url = asset('/');
    $route_url = route('dashboard');
    if(config('app.env') == 'production') {
        $img_url = "https://mipo.com.py/";
        $route_url = $img_url.'dashboard';
    }
@endphp
  <p style="text-align: center;color:#707070;padding-top:64px;">© Mipo {{ date('Y') }}</p>
  <a href="{{ $route_url }}" style="color:#0D6EFD;display:flex;text-decoration:none;justify-content:center;padding-top:10px;">www.mipo.com.py</a>
</tr>
</table>
</div>
</div>
</body>
</html>