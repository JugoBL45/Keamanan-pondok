@extends('layout.main')

@section('title', 'Create Permission')

@section('kont')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Create Permission</h3>
  </div>
  <div class="card-body">
    <form action="{{ route('permissions.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="santri_id">Santri</label>
        <select class="form-control" id="santri_id" name="santri_id" required>
          @foreach($santris as $santri)
          <option value="{{ $santri->id }}">{{ $santri->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="reason">Reason</label>
        <input type="text" class="form-control" id="reason" name="reason" required>
      </div>
      <div class="form-group">
        <label for="start_time">Start Time</label>
        <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
      </div>
      <div class="form-group">
        <label for="end_time">End Time</label>
        <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
