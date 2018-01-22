<table>
  <tr>
    <td class="content footer" align="center">
      <p><a href="#">{{ $sitename }}</a>, {{ env("SITE_ADDRESS", "Unspecified site address") }}</p>
      <p><a href="mailto:{{ env("SITE_EMAIL", "me@my.com") }}">{{ env("SITE_EMAIL", "Unspecified site email") }}</a> | <a href="{{ env("LIVE_URL", "#") }}">{{ env("LIVE_URL", "Unspecified site url") }}</a></p>
    </td>
  </tr>
</table>
