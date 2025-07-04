<?php

namespace Prezet\Prezet\Data;

use Carbon\Carbon;
use Prezet\Prezet\Exceptions\FrontmatterException;
use WendellAdriel\ValidatedDTO\Attributes\Rules;
use WendellAdriel\ValidatedDTO\Casting\CarbonCast;
use WendellAdriel\ValidatedDTO\Concerns\EmptyRules;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class FrontmatterData extends ValidatedDTO
{
    use EmptyRules;

    #[Rules(['required', 'string'])]
    public string $title;

    #[Rules(['required', 'string'])]
    public string $excerpt;

    #[Rules(['nullable', 'string'])]
    public ?string $category;

    #[Rules(['nullable', 'string'])]
    public ?string $image;

    #[Rules(['bool'])]
    public bool $draft;

    #[Rules(['required'])]
    public Carbon $date;

    #[Rules(['nullable', 'string'])]
    public ?string $author;

    #[Rules(['nullable', 'string'])]
    public ?string $slug;

    #[Rules(['nullable', 'string'])]
    public ?string $key;

    /**
     * @var array<int, string> $tags
     */
    #[Rules(['array'])]
    public array $tags;


    #[Rules(['array'])]
    public array $keywords;

    #[Rules(['nullable', 'string'])] //e.g. stacked-peaks-haikei
    public ?string $bg_pattern;

    #[Rules(['nullable', 'string'])] //e.g. bg-no-repeat bg-cover bg-center
    public ?string $bg_pattern_class;

    #[Rules(['nullable', 'bool'])]
    public ?bool $bg_pattern_repeat;

    /**
     * @return array<string, array<int, null>|false>
     */
    protected function defaults(): array
    {
        return [
            'tags' => [],
            'draft' => false,
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function mapData(): array
    {
        return [
            'description' => 'excerpt',
        ];
    }

    /**
     * @return array<string, string|CarbonCast>
     */
    protected function casts(): array
    {
        return [
            'date' => new CarbonCast,
        ];
    }

    /**
     * @throws FrontmatterException
     */
    protected function failedValidation(): void
    {
        throw new FrontmatterException($this->validator->errors(), $this->data['title'] ?? false);
    }
}
