@extends('layouts.app')

@section('content')
    <h1>Conflicting Emotions</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Content</th>
                <th>Emotion</th>
                <th>Intensity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
            <tr>
                <td>{{ $entry->id }}</td>
                <td>{{ $entry->created_at->format('Y-m-d') }}</td>
                <td>{{ $entry->content }}</td>
                <td>Sad</td>
                <td>{{ $entry->intensity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
