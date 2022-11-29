@extends('layouts.admin')

@section('content')
    <book-create
        :data="{{ json_encode([

            'urlStore' => route('book.store'),
            'urlCheckNameBook' => route('book.checkName'),
            'title' => $title,
            'urlBack' => route('book.index'),
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
            'Add' => __('Add'),
            'max255' => __('max255'),

        ]) }}">
    </book-create>
@endsection
