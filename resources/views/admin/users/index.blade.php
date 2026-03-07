@extends('layouts.admin')

@section('admin_content')

    <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4>Vendors & Users</h4>
            <p class="mb-0">Manage all registered accounts and their system roles</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group" style="background: #fff; border: 1px solid #eef2f6; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02); min-width: 320px;">
                    <span class="input-group-text bg-transparent border-0 pe-1 text-muted">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none px-2" placeholder="Search users by name, email..."
                        value="{{ request('search') }}" style="font-size: 0.9rem;">
                    <button type="submit" class="btn border-0" style="background:var(--primary-color, #F68B1E); color:#fff; border-radius: 6px; margin: 4px; padding: 4px 16px; font-weight: 500; font-size: 0.85rem;">
                        Search
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="btn" style="background: #fff2f2; color: #ff6b6b; border: 1px solid #ffecf2; border-radius: 8px; font-weight: 500; font-size: 0.85rem; padding: 8px 16px;">
                        Clear
                    </a>
                @endif
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn" style="background: #1a1a2e; color:#fff; border-radius: 8px; font-weight: 600; font-size: 0.85rem; padding: 9px 20px; box-shadow: 0 4px 12px rgba(26,26,46,0.15);">
                <i class="fa fa-plus me-2"></i> Add New User
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="table-responsive">
            <table class="table mb-0 admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end" style="padding-right:20px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td style="padding-left:20px;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="biz-avatar" style="border-radius:50%; background: {{ in_array($user->role, ['admin', 'super_admin']) ? '#1a1a2e' : (in_array($user->role, ['moderator', 'support']) ? '#eaf0ff' : ($user->role == 'vendor' ? '#fff8ec' : '#f4f6f9')) }}; color: {{ in_array($user->role, ['admin', 'super_admin']) ? '#fff' : (in_array($user->role, ['moderator', 'support']) ? '#4f6ef7' : ($user->role == 'vendor' ? '#F68B1E' : '#888')) }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.875rem; color:#1a1a2e;">{{ $user->name }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.update_role', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <select name="role" onchange="this.form.submit()"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                        style="border:1px solid #eee; border-radius:8px; padding:5px 10px; font-size:0.8rem; color:#333; background:#fff; cursor:pointer; outline:none;">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                        <option value="support" {{ $user->role == 'support' ? 'selected' : '' }}>Support</option>
                                        <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <span class="status-badge" style="{{ $user->status == 'active' ? 'background:#edfaf1; color:#34c76f;' : 'background:#f4f6f9; color:#888;' }}">
                                    {{ ucfirst($user->status ?: 'Active') }}
                                </span>
                            </td>
                            <td style="color:#888; font-size:0.825rem;">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="text-end" style="padding-right:20px;">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn" style="border:1px solid #eef2f6; background:#fff; color:#555; border-radius:8px; padding:5px 10px; font-size:0.78rem;">
                                        <i class="fa fa-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn" style="border:1px solid #eef2f6; background:#fff; color:#555; border-radius:8px; padding:5px 10px; font-size:0.78rem;">
                                        <i class="fa fa-edit me-1"></i>Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Permanently delete this user?')"
                                                style="border:1px solid #ffd5d5; background:#fff2f2; color:#ff6b6b; border-radius:8px; padding:5px 10px; font-size:0.78rem; cursor:pointer;">
                                                <i class="fa fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small align-self-center px-3">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid #f4f6f9;">
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection