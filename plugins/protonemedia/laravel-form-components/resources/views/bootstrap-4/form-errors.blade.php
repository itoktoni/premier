@error($name, $bag)
    <div {!! $attributes->merge(['class' => 'pristine-error text-help']) !!}>
        {{ $message }}
    </div>
@enderror