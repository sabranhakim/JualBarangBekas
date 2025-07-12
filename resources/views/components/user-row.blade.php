<tr class="border-b hover:bg-gray-50">
    <td class="px-4 py-2">{{ $index }}</td>
    <td class="px-4 py-2">{{ $user->name }}</td>
    <td class="px-4 py-2">{{ $user->email }}</td>
    <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
    <td class="px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
</tr>
