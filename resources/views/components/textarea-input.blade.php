@props(['disabled' => false])
<textarea @disabled($disabled) {{
  $attributes->merge(['class' => 'textarea textarea-bordered textarea-md w-full']) }}></textarea>