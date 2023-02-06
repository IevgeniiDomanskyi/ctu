@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://static.wixstatic.com/media/2b0eb1_aecc51e6975043508bba3a4ea668280e~mv2.png/v1/fill/w_330,h_82,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/Screen_Shot_2023-01-10_at_12_50_14_AM-removebg-preview.png" class="yh-logo" alt="{{ $slot }} Logo">
@endif
</a>
</td>
</tr>
