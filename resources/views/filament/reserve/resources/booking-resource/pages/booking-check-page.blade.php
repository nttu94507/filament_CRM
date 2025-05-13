<x-filament::page >
    <h2 class="text-xl font-bold mb-4">查詢與取消預約</h2>

    {{-- 查詢表單 --}}
    <form method="GET">
        <x-filament::input name="phone" placeholder="手機號碼" required
                           value="{{ request('phone') }}" class="mb-2 border border-gray-300 rounded-md shadow-sm" />
        <x-filament::input name="booking_code" placeholder="預約碼（6碼）" required
                           value="{{ request('booking_code') }}" class="mb-4 border border-gray-300 rounded-md shadow-sm" />
        <x-filament::button type="submit">查詢</x-filament::button>
    </form>

    @if (session('success'))
        <div class="text-green-600 mt-4">{{ session('success') }}</div>
    @endif

    {{-- 查詢結果 --}}
    @if ($booking)
        <div class="border p-4 mt-6 rounded">
            <p><strong>姓名：</strong>{{ $booking->name }}</p>
            <p><strong>日期：</strong>{{ $booking->date }}</p>
            <p><strong>時間：</strong>{{ substr($booking->time, 0, 5) }}</p>
            <p><strong>人數：</strong>{{ $booking->people_count }}</p>
            <p><strong>備註：</strong>{{ $booking->note ?? '' }}</p>

            {{-- 修改表單 --}}
            <form wire:submit.prevent="updateBooking" class="mt-4 space-y-3">
                <x-filament::input type="date" wire:model.defer="editDate" label="修改日期" required />
                <x-filament::input.select wire:model.defer="editTime" label="修改時間" required>
                    @foreach ([
                        '09:00:00' => '09:00',
                        '13:00:00' => '13:00',
                        '15:00:00' => '15:00',
                    ] as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </x-filament::input.select>

                <x-filament::button type="submit" color="primary">
                    換個時間
                </x-filament::button>
            </form>

            {{-- 取消按鈕 --}}
            <form wire:submit.prevent="deleteBooking" class="mt-4">
                <x-filament::button color="danger" type="submit"
                                    onclick="return confirm('確定要取消預約嗎？')">
                    取消預約
                </x-filament::button>
            </form>
        </div>
    @elseif(request()->filled(['phone', 'booking_code']))
        <p class="text-red-600 mt-4">查無符合的預約資料。</p>
    @endif
</x-filament::page>
