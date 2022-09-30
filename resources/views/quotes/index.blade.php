<x-structure>
    <form class="form" action="{{ route('quotes.fetch') }}" method="post">
        @csrf
        <div>
            <ul>
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div >
            <label>Company Symbol</label>
            <select required="required" name="symbol">
                @foreach($companies as $company)
                    <option value="{{ $company->symbol }}">
                        {{ $company->symbol }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Start Date</label>
            <input type="text" id="from" name="start" required/>
        </div>
        <div>
            <label>End Date</label>
            <input type="text" id="to" name="end" required/>
        </div>
        <div>
            <label>Email</label>
            <input required="required" type="email"  placeholder="Input recipients email" name="email"/>
        </div>
        <div>
            <button type="submit">
                Get Data
            </button>
        </div>
    </form>
</x-structure>