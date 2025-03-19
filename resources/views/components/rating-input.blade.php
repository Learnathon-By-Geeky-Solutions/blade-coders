@props(['name', 'value', 'disabled' => false])

<div class="rating-group">
    <input class="rating__input rating__input--none" name="{{ $name }}" id="{{ $name }}-0" value="0.0" type="radio" {{ $value == 0.0 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="0 stars" class="rating__label" for="{{ $name }}-0">&nbsp;</label>
    <label aria-label="0.5 stars" class="rating__label rating__label--half" for="{{ $name }}-05">
        <i class="rating__icon rating__icon--star fa fa-star-half"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-05" value="0.5" type="radio" {{ $value == 0.5 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="1 star" class="rating__label" for="{{ $name }}-10">
        <i class="rating__icon rating__icon--star fa fa-star"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-10" value="1.0" type="radio" {{ $value == 1.0 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="1.5 stars" class="rating__label rating__label--half" for="{{ $name }}-15">
        <i class="rating__icon rating__icon--star fa fa-star-half"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-15" value="1.5" type="radio" {{ $value == 1.5 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="2 stars" class="rating__label" for="{{ $name }}-20">
        <i class="rating__icon rating__icon--star fa fa-star"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-20" value="2.0" type="radio" {{ $value == 2.0 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="2.5 stars" class="rating__label rating__label--half" for="{{ $name }}-25">
        <i class="rating__icon rating__icon--star fa fa-star-half"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-25" value="2.5" type="radio" {{ $value == 2.5 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="3 stars" class="rating__label" for="{{ $name }}-30">
        <i class="rating__icon rating__icon--star fa fa-star"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-30" value="3.0" type="radio" {{ $value == 3.0 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="3.5 stars" class="rating__label rating__label--half" for="{{ $name }}-35">
        <i class="rating__icon rating__icon--star fa fa-star-half"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-35" value="3.5" type="radio" {{ $value == 3.5 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="4 stars" class="rating__label" for="{{ $name }}-40">
        <i class="rating__icon rating__icon--star fa fa-star"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-40" value="4.0" type="radio" {{ $value == 4.0 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="4.5 stars" class="rating__label rating__label--half" for="{{ $name }}-45">
        <i class="rating__icon rating__icon--star fa fa-star-half"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-45" value="4.5" type="radio" {{ $value == 4.5 ? 'checked' : '' }} @disabled($disabled)>
    <label aria-label="5 stars" class="rating__label" for="{{ $name }}-50">
        <i class="rating__icon rating__icon--star fa fa-star"></i>
    </label>
    <input class="rating__input" name="{{ $name }}" id="{{ $name }}-50" value="5.0" type="radio" {{ $value == 5.0 ? 'checked' : '' }} @disabled($disabled)>
</div>
