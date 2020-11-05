

@extends('front.layouts.master')
@section('title','İletişim')
@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-8">
              <div class="alert alert-info text-center">Bizimle İletişime Geçebilirsiniz.</div>
              <form method="post" action="{{route('contact.post')}}">
                  @csrf
                  <div class="form-group">
                      <label>Ad Soyad</label>
                      <input type="text" class="form-control" name="name" required>
                  </div>
                  <div class="form-group">
                      <label>Email Adress</label>
                      <input type="text" class="form-control" name="email" required>
                  </div>
                  <div class="form-group">
                      <label>Konu</label>
                      <select name="topic" class="form-control" required>
                          <option value="">Seçim Yapın</option>
                          <option value="Bilgi">Bilgi</option>
                          <option value="İş Başvurusu">İş Başvurusu</option>
                          <option value="Şikayet">Şikayet</option>
                          <option value="Öneri">Öneri</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Mesajınız</label>
                      <textarea name="message" class="form-control" rows="6" required></textarea>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="float-right btn btn-primary">Gönder</button>
                  </div>
              </form>
          </div>
          <div class="col-md-4">
              asdfgeghopıjptgkroeğf
          </div>
      </div>
  </div>
@endsection
