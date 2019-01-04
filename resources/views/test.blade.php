<form action="{{ url('debug/upload') }}" method="post" enctype="multipart/form-data">

    <input type="text" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="gambar" id="">
    <input type="submit" value="kirim">
</form>
