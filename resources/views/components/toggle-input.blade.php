@props(['disabled' => false, 'value' => false])
<input @disabled($disabled) type="checkbox"
  class="toggle border-grey-500 bg-grey-500 [--tglbg:white] hover:bg-primary" />