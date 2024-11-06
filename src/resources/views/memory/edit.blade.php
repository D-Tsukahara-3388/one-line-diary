@extends('adminlte::page')

@section('title', '投稿編集')

@section('content_header')
    <h1>投稿編集</h1>
@stop

@section('content')
 <!-- Main content -->
    <section class="content">
    @if($errors->any())
      <div class="alert alert-danger">
          入力内容に問題があります。もう一度確認して修正してください。
          <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
      </div>
    @endif
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card">
              <!-- form start -->
              <form action="{{ route('memory.update', ['memory' => $memory->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">                
                  <div class="form-group">
                    <label>日付</label>
                    <div class="input-group">
                      <input type="text" 
                             name="recorded_date" 
                             value="{{ old('recorded_date', str_replace('-', '/', $memory->recorded_date)) }}" disabled />
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label for="inputSentence">日記</label>
                    <input type="text" class="form-control" name="sentence" value="{{ old('sentence', $memory->sentence) }}" id="inputSentence" placeholder="50文字以内">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">画像(jpg)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image_file_path" id="imageUpload" accept="image/jpeg">
                        <label class="custom-file-label" for="imageUpload"></label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>プレビュー</label>
                    <img id="imagePreview" 
                         src="{{ $memory->image_file_path ? url('/image/' . $memory->user_id . '/' . $memory->image_file_path) : '' }}" 
                         alt="プレビュー画像" 
                         style="display: {{ $memory->image_file_path ? 'block' : 'none' }}; max-width: 50%; height: auto;">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="{{ route('memory.index') }}" class="btn btn-secondary">戻る</a>
                  <button type="submit" class="btn btn-primary">保存</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div> 
    </section>
@stop

@section('css')

@stop

@section('js')

<script>
// ファイルが選択されたときに実行されるイベント
document.getElementById('imageUpload').addEventListener('change', function(event) {
    const file = event.target.files[0];

    // 画像ファイルが選ばれたかチェックし、かつJPEG形式かチェック
    if (file && file.type === 'image/jpeg') {
        const reader = new FileReader();

        // ファイルが読み込まれたら、画像のプレビューを表示
        reader.onload = function(e) {
            const imgElement = document.getElementById('imagePreview');
            imgElement.src = e.target.result; // 読み込んだ画像をimgタグにセット
            imgElement.style.display = 'block'; // プレビュー画像を表示
        };

        // ファイルを読み込む
        reader.readAsDataURL(file);
    } else {
        // JPEG形式でない場合はプレビューを非表示に
        document.getElementById('imagePreview').style.display = 'none';

        // 警告メッセージを表示（任意）
        alert('JPG形式の画像を選択してください。');
    }
});

// 初期状態でDBから取得した画像URLがあれば、プレビューとして表示
window.onload = function() {
    const existingImageUrl = "{{ $existingImageUrl ?? '' }}"; // 既存の画像URL
    if (existingImageUrl) {
        const imgElement = document.getElementById('imagePreview');
        imgElement.src = existingImageUrl; // DBから取得した画像URLをセット
        imgElement.style.display = 'block'; // プレビュー画像を表示
    }
};
</script>
@stop