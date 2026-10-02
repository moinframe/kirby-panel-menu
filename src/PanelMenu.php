<?php

namespace Moinframe\PanelMenu;

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\A;
use Closure;

/**
 * Kirby Panel Menu Plugin
 *
 * A fluent, chainable PHP class for managing Kirby CMS panel menu entries.
 *
 * A comprehensive class for managing Kirby panel menu entries with support for
 * pages, sites, UUIDs, dialogs, drawers, and active state management.
 */
class PanelMenu
{
	/**
	 * The menu entries collection
	 * @var array<mixed>
	 */
	protected array $entries = [];

	/**
	 * The Kirby app instance
	 */
	protected App $kirby;

	/**
	 * Constructor
	 */
	public function __construct(?App $kirby = null)
	{
		$this->kirby = $kirby ?? App::instance();
	}

	/**
	 * Create a menu entry for a page
	 *
	 * @param string $label The label for the menu entry
	 * @param string|Page $page The page path, Page object, or UUID (page://uuid)
	 * @param array<string, mixed> $options Additional options (icon, target, title)
	 * @return self
	 */
	public function page(string $label, string|Page $page, array $options = []): self
	{
		$pageObject = $this->resolvePage($page);

		if (!$pageObject) {
			throw new \InvalidArgumentException('Page not found: ' . (string)$page);
		}

		$link = $pageObject->panel()->path();

		// Without a custom 'current' option, the callback is generated
		// in toArray() once all page entries are known
		$this->entries[$link] = array_merge([
			'label' => $label,
			'link' => $link,
			'icon' => $options['icon'] ?? 'page',
		], $this->filterOptions($options, ['target', 'title', 'current']));

		return $this;
	}

	/**
	 * Create a menu entry for the site
	 *
	 * The label is intentionally omitted so Kirby falls back to the title
	 * defined in the site blueprint. Pass a 'label' option to override it.
	 *
	 * @param array<string, mixed> $options Options to customize the site entry
	 * @return self
	 */
	public function site(array $options = []): self
	{
		$defaults = [
			'icon' => 'home',
			'link' => 'site',
		];

		$this->entries['site'] = array_merge($defaults, $options);

		return $this;
	}

	/**
	 * Add a built-in panel area (users, languages, system)
	 *
	 * @param string $area The area name
	 * @param array<string, mixed> $options Optional customization options
	 * @return self
	 */
	public function area(string $area, array $options = []): self
	{

		if (count($options) === 0) {
			$this->entries[] = $area;
		} else {
			$this->entries[$area] = $options;
		}

		return $this;
	}

	/**
	 * Add a custom menu entry
	 *
	 * @param string $key The entry key/identifier
	 * @param array<string, mixed> $config The entry configuration
	 * @return self
	 */
	public function custom(string $key, array $config): self
	{
		if (!isset($config['label'])) {
			throw new \InvalidArgumentException("Menu entry must have a 'label'");
		}

		if (!isset($config['icon'])) {
			throw new \InvalidArgumentException("Menu entry must have an 'icon'");
		}

		// Must have either link, dialog, or drawer
		if (!isset($config['link']) && !isset($config['dialog']) && !isset($config['drawer'])) {
			throw new \InvalidArgumentException("Menu entry must have either 'link', 'dialog', or 'drawer'");
		}

		$this->entries[$key] = $config;

		return $this;
	}

	/**
	 * Add a menu entry with a dialog
	 *
	 * @param string $key The entry key
	 * @param string $label The label
	 * @param string $dialog The dialog path
	 * @param array<string, mixed> $options Additional options
	 * @return self
	 */
	public function dialog(string $key, string $label, string $dialog, array $options = []): self
	{
		$this->entries[$key] = array_merge([
			'label' => $label,
			'icon' => $options['icon'] ?? 'dialog',
			'dialog' => $dialog,
		], $this->filterOptions($options, ['target', 'title', 'current']));

		return $this;
	}

	/**
	 * Add a menu entry with a drawer
	 *
	 * @param string $key The entry key
	 * @param string $label The label
	 * @param string $drawer The drawer path
	 * @param array<string, mixed> $options Additional options
	 * @return self
	 */
	public function drawer(string $key, string $label, string $drawer, array $options = []): self
	{
		$this->entries[$key] = array_merge([
			'label' => $label,
			'icon' => $options['icon'] ?? 'drawer',
			'drawer' => $drawer,
		], $this->filterOptions($options, ['target', 'title', 'current']));

		return $this;
	}

	/**
	 * Add a separator (gap) between menu entries
	 *
	 * @return self
	 */
	public function separator(): self
	{
		$this->entries['separator-' . count($this->entries)] = '-';
		return $this;
	}

	/**
	 * Create a "current" callback for highlighting active menu items
	 *
	 * @param string|array<string> $paths The path(s) to check against
	 * @return Closure
	 */
	public function currentCallback(string|array $paths): Closure
	{
		$paths = is_array($paths) ? $paths : [$paths];

		return function () use ($paths) {
			$currentPath = $this->kirby->path();

			foreach ($paths as $path) {
				if (static::pathMatches($currentPath, $path)) {
					return true;
				}
			}

			return false;
		};
	}

	/**
	 * Create a "current" callback that excludes specific paths
	 * Useful for the site entry when you have custom page entries
	 *
	 * @param string $baseMatch The base match string (e.g., 'site')
	 * @param array<string> $excludePaths Paths to exclude
	 * @return Closure
	 */
	public function currentExcluding(string $baseMatch, array $excludePaths): Closure
	{
		return function (?string $current) use ($baseMatch, $excludePaths): bool {
			$currentPath = $this->kirby->path();

			return $current === $baseMatch &&
				A::every($excludePaths, fn($link) => !static::pathMatches($currentPath, $link));
		};
	}

	/**
	 * Add a create page dialog menu entry
	 *
	 * @param string $key The entry key
	 * @param string $label The label
	 * @param string $parentPage The parent page ID or UUID
	 * @param string $view The view name
	 * @param string $section The section name
	 * @param array<string, mixed> $options Additional options
	 * @return self
	 */
	public function createPage(
		string $key,
		string $label,
		string $parentPage,
		string $view,
		string $section,
		array $options = []
	): self {
		$pageObject = $this->resolvePage($parentPage);

		if (!$pageObject) {
			throw new \InvalidArgumentException("Parent page not found: {$parentPage}");
		}

		$parentId = str_replace('/', '+', $pageObject->id());
		$dialog = "pages/create?parent=/pages/{$parentId}&view={$view}&section={$section}";

		return $this->dialog($key, $label, $dialog, array_merge([
			'icon' => 'add'
		], $options));
	}

	/**
	 * Resolve a page from various input formats
	 *
	 * Supports:
	 * - Page objects
	 * - Page paths (e.g., 'blog/my-post')
	 * - UUID references (e.g., 'page://uuid')
	 *
	 * @param string|Page $input The page input
	 * @return Page|null
	 */
	protected function resolvePage(string|Page $input): ?Page
	{
		if ($input instanceof Page) {
			return $input;
		}

		return $this->kirby->page($input);
	}

	/**
	 * Check whether a panel path points to the given link or one of its children
	 *
	 * Matches whole path segments only, so `pages/film` matches
	 * `panel/pages/film` and `panel/pages/film+trailer`, but not
	 * `panel/pages/filmreihe`.
	 *
	 * @param string $path The current request path
	 * @param string $link The menu entry link
	 * @return bool
	 */
	protected static function pathMatches(string $path, string $link): bool
	{
		$link = trim($link, '/');

		if ($link === '') {
			return false;
		}

		return preg_match('#(^|/)' . preg_quote($link, '#') . '($|[/+?])#', $path) === 1;
	}

	/**
	 * Find the most specific link that matches the given path
	 *
	 * For `panel/pages/photography+sky` and the links `pages/photography`
	 * and `pages/photography+sky`, the latter wins.
	 *
	 * @param string $path The current request path
	 * @param array<string> $links The links to check
	 * @return string|null
	 */
	protected static function closestMatch(string $path, array $links): ?string
	{
		$closest = null;

		foreach ($links as $link) {
			if (
				static::pathMatches($path, $link) &&
				strlen($link) > strlen($closest ?? '')
			) {
				$closest = $link;
			}
		}

		return $closest;
	}

	/**
	 * Filter allowed options from an options array
	 *
	 * @param array<string, mixed> $options The options array
	 * @param array<string> $allowed The allowed keys
	 * @return array<string, mixed>
	 */
	protected function filterOptions(array $options, array $allowed): array
	{
		return array_filter(
			$options,
			fn($key) => in_array($key, $allowed, true),
			ARRAY_FILTER_USE_KEY
		);
	}


	/**
	 * Convert to array (for use in config)
	 *
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		$entries = $this->entries;
		$kirby = $this->kirby;

		$pageLinks = array_values(array_filter(
			array_keys($entries),
			fn($key) => is_string($key) && Str::startsWith($key, 'pages/')
		));

		// Auto-generate current callbacks for page entries. When nested pages
		// are in the menu, only the most specific matching entry is active.
		foreach ($pageLinks as $link) {
			if (isset($entries[$link]['current'])) {
				continue;
			}

			$entries[$link]['current'] = function (?string $current) use ($link, $pageLinks, $kirby): bool {
				return static::closestMatch($kirby->path(), $pageLinks) === $link;
			};
		}

		// Auto-generate current callback for site entry when page entries exist
		if (isset($entries['site']) && !isset($entries['site']['current'])) {
			if (!empty($pageLinks)) {
				$entries['site']['current'] = function (?string $current) use ($pageLinks, $kirby): bool {
					$path = $kirby->path();
					return $current === 'site' &&
						A::every($pageLinks, fn($link) => !static::pathMatches($path, $link));
				};
			}
		}

		return $entries;
	}

	/**
	 * Static factory method
	 *
	 * @param App|null $kirby Optional Kirby instance
	 * @return self
	 */
	public static function create(?App $kirby = null): self
	{
		return new self($kirby);
	}
}
