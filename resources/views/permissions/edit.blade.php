@extends('layout.main')

@section('title', 'Edit Permission')

@section('kont')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Permission</h3>
  </div>
  <div class="card-body">
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="santri_id">Santri</label>
        <select class="form-control" id="santri_id" name="santri_id" required>
          @foreach($santris as $santri)
          <option value="{{ $santri->id }}" {{ $santri->id == $permission->santri_id ? 'selected' : '' }}>{{ $santri->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="reason">Reason</label>
        <input type="text" class="form-control" id="reason" name="reason" value="{{ $permission->reason }}" required>
      </div>
      <div class="form-group">
        <label for="start_time">Start Time</label>
        <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ $permission->start_time }}" required>
      </div>
      <div class="form-group">
        <label for="end_time">End Time</label>
        <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ $permission->end_time }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
