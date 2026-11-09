
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - CiwiExplore</title>
    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">

    <style>
        .edit-user-container {
            max-width: 650px;
            margin: 40px auto;
            padding: 25px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0,0,0,.06);
        }

        .edit-user-container label {
            display: block;
            margin: 17px 0 7px;
            font-weight: 600;
        }

        .edit-user-container input,
        .edit-user-container select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 7px;
            box-sizing: border-box;
        }

        .edit-user-container button {
            margin-top: 22px;
            padding: 12px 18px;
            border: none;
            border-radius: 7px;
            background: #23734d;
            color: white;
            cursor: pointer;
        }

        .field-error {
            color: #c0392b;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="edit-user-container">

    <h1>Edit Akun Pengguna</h1>
    <p>Perbarui informasi akun pengguna CiwiExplore.</p>

    <form action="{{ route('admin.users.update', $user->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <label for="name">Nama Pengguna</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
        >
        @error('name')
            <div class="field-error">{{ $message }}</div>
        @enderror

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            required
        >
        @error('email')
            <div class="field-error">{{ $message }}</div>
        @enderror

        <label for="role">Role Pengguna</label>
        <select
            name="role"
            id="role"
            required
            @disabled($user->id === auth()->id())
        >
            <option value="pengunjung"
                @selected(old('role', $user->role) === 'pengunjung')>
                Pengunjung
            </option>

            <option value="pengelola"
                @selected(old('role', $user->role) === 'pengelola')>
                Pengelola
            </option>

            <option value="admin"
                @selected(old('role', $user->role) === 'admin')>
                Admin
            </option>
        </select>

        @if ($user->id === auth()->id())
            <small>Role akun sendiri tidak dapat diubah.</small>
        @endif

        @error('role')
            <div class="field-error">{{ $message }}</div>
        @enderror

        <p>
            Status akun saat ini:
            <strong>{{ ucfirst($user->status) }}</strong>
        </p>

        <button type="submit">Simpan Perubahan</button>

        <a href="{{ route('admin.users.index') }}"
           style="margin-left:10px">
            Batal
        </a>

    </form>

</div>

</body>
</html>
