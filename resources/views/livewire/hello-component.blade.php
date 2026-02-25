<div>
    <ul>
        <li>{{$message}}</li>
    </ul>
    <form wire:submit.prevent="updateMessage">
    <input type="text" wire:model="input">
    <button type="submit">Click</button>

    @error('input')
    <p style="font-size:10pt;">{{ $message }}</p>
    @enderror
    </form>
</div>
