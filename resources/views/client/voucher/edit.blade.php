@extends('client.layouts.app-main')
<style>
    select {
        font-weight: bold;
    }
</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h3 class="custom-title font-weight-bold">
                            @isset($voucher)
                                تعديل قيود اليومية
                            @else
                                اضافة قيود اليومية
                            @endisset
                        </h3>
                        <a class="btn btnn text-white py-1 px-3" style="background-color: #ec6880" href="{{ route('client.voucher.get') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">
                    <form id="storevoucher"
                        action="{{ isset($voucher) ? route('client.voucher.update', $voucher->id) : route('client.voucher.store') }}"
                        method="post">
                        @csrf
                        @if (isset($voucher))
                            @method('PUT')
                        @endif

                        <div class="row p-0 mb-1">
                            <!-- Date and Notation -->
                            <div class="row col-12 p-0 pb-2 pl-1 border-bottom border-secondary">
                                <div class="col-md-6 pr-0">
                                    <label> التاريخ <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ old('date', $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('Y-m-d') : date('Y-m-d')) }}"
                                        required>
                                </div>

                                <div class="col-md-6  pr-0">
                                    <label> الملاحظات <span class="text-danger">*</span></label>
                                    <textarea required class="form-control" placeholder="الملاحظات" name="notation">{{ $voucher->notation }}</textarea>
                                </div>
                            </div>

                            <!-- Transactions Table -->
                            <div class="table-responsive pr-1 pl-1">
                                <table class="table mt-2">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">الحساب</th>
                                            <th scope="col">مدين</th>
                                            <th scope="col">دائن</th>
                                            <th scope="col">ملاحظات</th>
                                            <th scope="col">تحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyvouchers">

                                        <input type="hidden" name="amount" class="
                                        ">

                                        @foreach ($voucher->transactions as $transaction)
                                            <tr>
                                                <td>
                                                    <select required name="transactions[{{ $loop->index }}][account]"
                                                        class="form-control">
                                                        <option value="">اختر الحساب</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}"
                                                                {{ $account->id == $transaction->accounting_tree_id ? 'selected' : '' }}>
                                                                {{ $account->account_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="account-error text-danger"></span>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control debit"
                                                        @if ($transaction->type == 1) name="transactions[{{ $loop->index }}][amount]" @endif
                                                        value="{{ $transaction->type == 1 ? $transaction->amount : 0 }}">
                                                    <input type="hidden"
                                                        @if ($transaction->type == 1) name="transactions[{{ $loop->index }}][type]" @endif
                                                        value="1">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control credit"
                                                        @if ($transaction->type == 0) name="transactions[{{ $loop->index }}][amount]" @endif
                                                        value="{{ $transaction->type == 0 ? $transaction->amount : 0 }}">
                                                    <input type="hidden"
                                                        @if ($transaction->type == 0) name="transactions[{{ $loop->index }}][type]" @endif
                                                        value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="transactions[{{ $loop->index }}][notation]"
                                                        value="{{ $transaction->notation }}">
                                                </td>
                                                <td>
                                                    <input type="button" class="mt-1 btn btn-danger btn-sm deleteRow"
                                                        value="X" />
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td style="text-align: center">المجموع: <span id="totalDebit">0</span></td>
                                            <td style="text-align: center">المجموع: <span id="totalCredit">0</span></td>
                                            <td id="errorCell" style="color: red;"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <button type="button" class="btn btnn btn-primary addNewRowHandler">
                                    <i class="fa fa-plus"></i>
                                    {{ __('main.add new row') }}
                                </button>
                                <button class="btn btnn btn-success font-weight-bold"
                                    type="submit">{{ isset($voucher) ? __('main.update') : __('main.add') }}</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let selectedAccountIds = [];
        let rowIndex = $('.tbodyvouchers tr').length; // Keep track of the row index

        // Function to attach event listeners to new rows
        function attachRowEvents() {
            // Event listener for debit and credit fields
            $('.debit, .credit').off('input').on('input', function() {
                const row = $(this).closest('tr');
                const debitField = row.find('.debit');
                const creditField = row.find('.credit');
                const typeField = row.find('input[name$="[type]"]'); // Use the correct name pattern

                // Disable the other field and set the correct transaction type
                if ($(this).hasClass('debit') && $(this).val() !== '') {
                    creditField.prop('disabled', true).val(0);
                    typeField.val(1); // Debit
                } else if ($(this).hasClass('credit') && $(this).val() !== '') {
                    debitField.prop('disabled', true).val(0);
                    typeField.val(0); // Credit
                } else {
                    debitField.prop('disabled', false);
                    creditField.prop('disabled', false);
                    typeField.val(''); // No type if both are empty
                }

                calculateTotal();
            });
        }

        // Calculate total debit and credit
        function calculateTotal() {
            let totalDebit = 0;
            let totalCredit = 0;

            $('.tbodyvouchers tr').each(function() {
                const debitValue = parseFloat($(this).find('.debit').val()) || 0;
                const creditValue = parseFloat($(this).find('.credit').val()) || 0;

                totalDebit += debitValue;
                totalCredit += creditValue;
                $('.amount').val(totalDebit);

            });

            $('#totalDebit').text(totalDebit.toFixed(2));
            $('#totalCredit').text(totalCredit.toFixed(2));

            if (totalDebit !== totalCredit) {
                $('#errorCell').text('Error: Total debit is not equal to total credit.');
            } else {
                $('#errorCell').text('');
            }
        }

        // Update the selected account IDs
        function updateSelectedAccountIds() {
            selectedAccountIds = [];
            $('select[name$="[account]"]').each(function() {
                const accountId = $(this).val();
                if (accountId !== '') {
                    selectedAccountIds.push(accountId);
                }
            });
            updateAccountOptions();
        }

        // Show/hide account options based on selection
        function updateAccountOptions() {
            $('select[name$="[account]"]').each(function() {
                const currentVal = $(this).val();
                $(this).find('option').each(function() {
                    if ($(this).val() !== '' && $(this).val() !== currentVal) {
                        if (selectedAccountIds.includes($(this).val())) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    }
                });
            });
        }

        // Event delegation for delete row
        $(document).on('click', '.deleteRow', function() {
            $(this).closest('tr').remove();
            updateSelectedAccountIds();
            calculateTotal();
        });

        // Add new row handler
        $(".addNewRowHandler").click(function() {
            updateSelectedAccountIds();

            let newRow = `
            <tr>
                <td>
                    <select required name="transactions[${rowIndex}][account]" class="form-control">
                        <option value="">اختر الحساب</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                        @endforeach
                    </select>
                    <span class="account-error text-danger"></span>
                </td>
                <td>
                    <input type="number" step="any" class="form-control debit" name="transactions[${rowIndex}][amount]" value="0">
                    <input type="hidden" name="transactions[${rowIndex}][type]" value="1"> <!-- Debit type -->
                </td>
                <td>
                    <input type="number" class="form-control credit" name="transactions[${rowIndex}][amount]" step="any" value="0">
                    <input type="hidden" name="transactions[${rowIndex}][type]" value="0"> <!-- Credit type -->
                </td>
                <td>
                    <input type="text" class="form-control" name="transactions[${rowIndex}][notation]" value="">
                </td>
                <td>
                    <input type="button" class="mt-1 btn btn-danger btn-sm deleteRow" value="X" />
                </td>
            </tr>`;

            $('.tbodyvouchers').append(newRow);
            attachRowEvents(); // Re-attach event listeners to new row elements
            rowIndex++; // Increment row index for the next row
        });

        // Initial setup
        attachRowEvents();
        calculateTotal(); // Initial calculation
    });
</script>
