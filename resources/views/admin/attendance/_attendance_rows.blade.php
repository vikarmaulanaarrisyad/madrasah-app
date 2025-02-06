<tbody>
    @foreach ($learningActivity->students as $index => $student)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $student->full_name }}</td>
            <td>
                <select name="attendance[{{ $student->id }}]" class="form-control">
                    <option value="Hadir"
                        {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Hadir' ? 'selected' : '' }}>
                        Hadir</option>
                    <option value="Alpa"
                        {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Alpa' ? 'selected' : '' }}>
                        Alpa</option>
                    <option value="Sakit"
                        {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Sakit' ? 'selected' : '' }}>
                        Sakit</option>
                    <option value="Izin"
                        {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Izin' ? 'selected' : '' }}>
                        Izin</option>
                </select>
            </td>
        </tr>
    @endforeach
</tbody>
