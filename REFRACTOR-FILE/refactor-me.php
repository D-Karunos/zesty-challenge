<?php
/** ****************************************************************************
 *
 *  CODING ASSESSMENT - REFACTORING
 *
 *  The code below was taken from a real legacy website we inherited
 *  For this exercise the challenge is simple and open ended
 *  Simply make this easier to read, understand and maintain.
 *
 *  You may refactor as much or as little as you think necessary
 *  ASSUMPTIONS
 *   - Assume the queries give you the arrays/objects as demonstrated so far
 *   - WE will assume your code works - this exercise is about code structuring.
 *
 * ****************************************************************************/

include_once("REFRACTOR-FILE/refractor-controller.php");
?>

<!-- // Build Search Form -->
<div class="feature-filters feature-filters--block">
	<p>Events Filters</p>
	<div class="grid-x grid-padding-x">

		<div class="cell medium-4">
			<label for="datepicker" class="show-for-sr">label</label>
			<input id="datepicker" value="<?php CheckDateExists($eventsArray); ?>" class="hasDatepicker" />
		</div>

		<div class="cell medium-4">
			<label for="seewhatson" class="show-for-sr">When it's on</label>
			<select name="period" class="field" id="seewhatson">
				<option value="">When</option>
				<?php foreach ($when as $whenkey => $whendate): ?>
					<?php if (empty($eventsArray['when'])): ?>
						<?= '<option value="' . $whenkey . '">' . $whendate . '</option>' ?>
					<?php else:
						$eventPeriod = $eventsArray['when'];
						$selected = ($whenkey == $eventPeriod) ? 'selected="selected"' : '';
						?>
						<?= '<option value="' . $whenkey . '" ' . $selected . '>' . $whendate . '</option>' ?>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>

		<div class="cell medium-4">
			<label for="placestogo" class="show-for-sr">Where it's on</label>
			<select name="location" class="field" id="placestogo">
				<option value="">Where</option>
				<?php
				$args = array(
					'post_type' => 'event',
					'posts_per_page' => -1,
					'fields' => 'ids',
					'orderby' => 'meta_value',
					'meta_key' => 'location',
					'order' => 'ASC',
					'meta_query' => array(
						array(
							'key' => 'end_date',
							'value' => $today,
							'compare' => '>=',
							'type' => 'DATE'
						)
					)
				);
				$locations = get_posts($args);
				$eventLocations = array(); foreach ($locations as $location) {
					$eventLocations[] = get_field('location', $location);
				}

				foreach (array_unique($eventLocations) as $eventLocation) {
					if (array_key_exists('where', $eventsArray)):
						$searchedLocation = $eventsArray['where'];
					endif;

					if ($searchedLocation == $eventLocation):
						$selected = 'selected="selected"';
					endif;

					echo '<option value="' . $eventLocation . '" ' . $selected . '>' . $eventLocation . '</option>';
				}
				?>
			</select>
		</div>

		<div class="cell medium-4">
			<label for="eventsbytype" class="show-for-sr">Event Type</label>
			<select name="categoryID" class="field" id="eventsbytype">
				<option value="">Type</option>
				<?php foreach ($taxonomies as $term):
					$termSlug = $term->slug;

					if (array_key_exists('type', $eventsArray)): ?>
						<?php $searchedType = $eventsArray['type'] ?>
					<?php endif ?>

					<?php if ($searchedType == $termSlug): ?>
						<?php $selected = 'selected="selected"' ?>
					<?php endif ?>

					<?= '<option value="' . $term->slug . '" ' . $selected . '>' . $term->name . '</option>' ?>
				<?php endforeach ?>
			</select>
		</div>

		<div class="cell medium-4">
			<button class="cmd-filter cmd-filter--small event-filter" type="button">Filter Items</button>
			<button class="cmd-filter cmd-filter--small btn-clear" type="button">Clear Filters</button>
		</div>


	</div>
</div>
<!-- // Build Search Form -->