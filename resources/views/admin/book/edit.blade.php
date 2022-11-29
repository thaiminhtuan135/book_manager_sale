@extends('layouts.admin')
@section('content')
    <book-edit
        :data="{{json_encode([
            'urlUpdate' =>route('book.update',$book->id),
            'book' => $book,
            'title' => $title,
            'title1' => __('Title'),
            'Author' => __('Author'),
            'Description' => __('Description'),
            'Release_date' => __('Release_date'),
            'Number_page' => __('Number_page'),
            'Category' => __('Category'),
            'chooseCategory' => __('chooseCategory'),
            'Image' => __('Image'),
            'Upload' => __('Upload'),
            'requiredTitle' => __('requiredTitle'),
            'requiredAuthor' => __('requiredAuthor'),
            'requiredBookDescription' => __('requiredBookDescription'),
            'requiredRelease_date' => __('requiredRelease_date'),
            'requiredNumberPage' => __('requiredNumberPage'),
            'requiredCategory' => __('requiredCategory'),
            'formatReleaseDate' => __('formatReleaseDate'),
            'max255' => __('max255'),
            'Edit1' => __('Edit1'),
            'Save' => __('Save'),

    ]) }}">
    </book-edit>
@endsection
