<div class="text-center">
    <h3>{{ __('deskripsi: ') }} {{ $file->description }}</h3>
    <hr/>
    <object data="{{ $url }}" type="application/pdf" width="100%" height="100%">
        <p>Teks alternatif - tautan link <a href="{{ asset('storage/'.$file->file) }}">buka PDF!</a></p>
    </object>

</div>