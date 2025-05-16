<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->userId) {
            return User::where('id', $this->userId)->get();
        }
        
        return User::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Fecha de Registro',
            'Archivos Totales',
            'Imágenes',
            'Documentos',
            'Favoritos'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at->format('d/m/Y H:i'),
            $user->files()->count(),
            $user->files()->where('is_image', true)->count(),
            $user->files()->where('is_image', false)->count(),
            $user->files()->where('is_favorite', true)->count(),
        ];
    }
} 