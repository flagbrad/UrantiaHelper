<?php
class UrantiaHelperExtensionHooks {
    
    // Register any render callbacks with the parser
    public static function onParserFirstCallInit( Parser $parser ) {
        // Create a function hook associating the "tub" magic word with renderTheUrantiaBook()
        $parser->setFunctionHook( 'tub', [ self::class, 'renderTheUrantiaBook' ], SFH_NO_HASH );
    }
    
    // Render the output of {{tub:foo}}, where foo is a standard reference like 195:8.3.
    public static function renderTheUrantiaBook( Parser $parser, $param1 = '' ) {
        try {
            
            $refType = 'unknown';
            $url = 'https://www.urantia.org/urantia-book-standardized/';
            $suffix = '';
        
            // Remove brackets if someone put them in
            $bookref = trim($param1, '[]'); // Remove user-specified brackets
            $linktext = $bookref;

            // Is there a suffix?
            $bookref = explode(',', $bookref);
            if (count($bookref) > 1) {
                $suffix = ', ' . $bookref[1];
            }
            $bookref = $bookref[0];

            # Does it start with "Paper?"  If so, kindly remove it
            $bookref = explode(' ', $bookref);
            if (strcasecmp($bookref[0], 'paper') == 0) {
                $bookref = $bookref[1];
            } else {
                $bookref = $bookref[0];
            }

            // Is this one reference or two?
            $bookref = explode('-', $bookref);
            $endingbookref = '';
            if (count($bookref) > 1) {
                // It's two parts.
                $endingbookref = $bookref[1];
            }
            $bookref = $bookref[0];

            // Get paper-level reference before the colon
            $bookref = explode(':', $bookref);
            $papernum = $bookref[0];
            $url .= self::$_urantiaOrgPath[$papernum];

            // Keep looking past the colon, if there is one
            if (count($bookref) > 1) {
                // Is it section level, or paragraph level?
                $bookref = explode('.', $bookref[1]);
                $sectionnum = $bookref[0];
                $paragraphnum = 0;
                if (count($bookref) > 1) {
                    // Paragraph-level reference
                    $paragraphnum = $bookref[1];
                }
                $url .= "#U{$papernum}_{$sectionnum}_{$paragraphnum}";

            } else {
                // Paper-level reference only.  Prevent ambiguity ([195] versus [Paper 195])
                #$linktext = 'Paper ' . $linktext; 
            }
        
            return [
                "[$url <nowiki>[</nowiki>{$linktext}<nowiki>]</nowiki>]", 
                'isHTML' => false, 
                'noparse' => false,
            ];
    
        } catch (Excpetion $e) {
            return "__INVALID TUB REFERENCE__";
        }
    }

    static $_urantiaOrgPath = [
        'foreword',
        'paper-1-universal-father',
        'paper-2-nature-god',
        'paper-3-attributes-god',
        'paper-4-gods-relation-universe',
        'paper-5-gods-relation-individual',
        'paper-6-eternal-son',
        'paper-7-relation-eternal-son-universe',
        'paper-8-infinite-spirit',
        'paper-9-relation-infinite-spirit-universe',
        'paper-10-paradise-trinity',
        'paper-11-eternal-isle-paradise',
        'paper-12-universe-universes',
        'paper-13-sacred-spheres-paradise',
        'paper-14-central-and-divine-universe',
        'paper-15-seven-superuniverses',
        'paper-16-seven-master-spirits',
        'paper-17-seven-supreme-spirit-groups',
        'paper-18-supreme-trinity-personalities',
        'paper-19-co-ordinate-trinity-origin-beings',
        'paper-20-paradise-sons-god',
        'paper-21-paradise-creator-sons',
        'paper-22-trinitized-sons-god',
        'paper-23-solitary-messengers',
        'paper-24-higher-personalities-infinite-spirit',
        'paper-25-messenger-hosts-space',
        'paper-26-ministering-spirits-central-universe',
        'paper-27-ministry-primary-supernaphim',
        'paper-28-ministering-spirits-superuniverses',
        'paper-29-universe-power-directors',
        'paper-30-personalities-grand-universe',
        'paper-31-corps-finality',
        'paper-32-evolution-local-universes',
        'paper-33-administration-local-universe',
        'paper-34-local-universe-mother-spirit',
        'paper-35-local-universe-sons-god',
        'paper-36-life-carriers',
        'paper-37-personalities-local-universe',
        'paper-38-ministering-spirits-local-universe',
        'paper-39-seraphic-hosts',
        'paper-40-ascending-sons-god',
        'paper-41-physical-aspects-local-universe',
        'paper-42-energy-mind-and-matter',
        'paper-43-constellations',
        'paper-44-celestial-artisans',
        'paper-45-local-system-administration',
        'paper-46-local-system-headquarters',
        'paper-47-seven-mansion-worlds',
        'paper-48-morontia-life',
        'paper-49-inhabited-worlds',
        'paper-50-planetary-princes',
        'paper-51-planetary-adams',
        'paper-52-planetary-mortal-epochs',
        'paper-53-lucifer-rebellion',
        'paper-54-problems-lucifer-rebellion',
        'paper-55-spheres-light-and-life',
        'paper-56-universal-unity',
        'paper-57-origin-urantia',
        'paper-58-life-establishment-urantia',
        'paper-59-marine-life-era-urantia',
        'paper-60-urantia-during-early-land-life-era',
        'paper-61-mammalian-era-urantia',
        'paper-62-dawn-races-early-man',
        'paper-63-first-human-family',
        'paper-64-evolutionary-races-color',
        'paper-65-overcontrol-evolution',
        'paper-66-planetary-prince-urantia',
        'paper-67-planetary-rebellion',
        'paper-68-dawn-civilization',
        'paper-69-primitive-human-institutions',
        'paper-70-evolution-human-government',
        'paper-71-development-state',
        'paper-72-government-neighboring-planet',
        'paper-73-garden-eden',
        'paper-74-adam-and-eve',
        'paper-75-default-adam-and-eve',
        'paper-76-second-garden',
        'paper-77-midway-creatures',
        'paper-78-violet-race-after-days-adam',
        'paper-79-andite-expansion-in-orient',
        'paper-80-andite-expansion-in-occident',
        'paper-81-development-modern-civilization',
        'paper-82-evolution-marriage',
        'paper-83-marriage-institution',
        'paper-84-marriage-and-family-life',
        'paper-85-origins-worship',
        'paper-86-early-evolution-religion',
        'paper-87-ghost-cults',
        'paper-88-fetishes-charms-and-magic',
        'paper-89-sin-sacrifice-and-atonement',
        'paper-90-shamanism-medicine-men-and-priests',
        'paper-91-evolution-prayer',
        'paper-92-later-evolution-religion',
        'paper-93-machiventa-melchizedek',
        'paper-94-melchizedek-teachings-in-orient',
        'paper-95-melchizedek-teaching-in-levant',
        'paper-96-yahweh-god-hebrews',
        'paper-97-evolution-god-concept-among-hebrews',
        'paper-98-melchizedek-teachings-in-occident',
        'paper-99-social-problems-religion',
        'paper-100-religion-in-human-experience',
        'paper-101-real-nature-religion',
        'paper-102-foundations-religious-faith',
        'paper-103-reality-religious-experience',
        'paper-104-growth-trinity-concept',
        'paper-105-deity-and-reality',
        'paper-106-universe-levels-reality',
        'paper-107-origin-and-nature-thought-adjusters',
        'paper-108-mission-and-ministry-thought-adjusters',
        'paper-109-relation-adjusters-universe-creatures',
        'paper-110-relation-adjusters-individual-mortals',
        'paper-111-adjuster-and-soul',
        'paper-112-personality-survival',
        'paper-113-seraphic-guardians-destiny',
        'paper-114-seraphic-planetary-government',
        'paper-115-supreme-being',
        'paper-116-almighty-supreme',
        'paper-117-god-supreme',
        'paper-118-supreme-and-ultimate-time-and-space',
        'paper-119-bestowals-christ-michael',
        'paper-120-bestowal-michael-urantia',
        'paper-121-times-michaels-bestowal',
        'paper-122-birth-and-infancy-jesus',
        'paper-123-early-childhood-jesus',
        'paper-124-later-childhood-jesus',
        'paper-125-jesus-jerusalem',
        'paper-126-two-crucial-years',
        'paper-127-adolescent-years',
        'paper-128-jesus-early-manhood',
        'paper-129-later-adult-life-jesus',
        'paper-130-way-rome',
        'paper-131-worlds-religions',
        'paper-132-sojourn-rome',
        'paper-133-return-rome',
        'paper-134-transition-years',
        'paper-135-john-baptist',
        'paper-136-baptism-and-forty-days',
        'paper-137-tarrying-time-in-galilee',
        'paper-138-training-kingdoms-messengers',
        'paper-139-twelve-apostles',
        'paper-140-ordination-twelve',
        'paper-141-beginning-public-work',
        'paper-142-passover-jerusalem',
        'paper-143-going-through-samaria',
        'paper-144-gilboa-and-in-decapolis',
        'paper-145-four-eventful-days-capernaum',
        'paper-146-first-preaching-tour-galilee',
        'paper-147-interlude-visit-jerusalem',
        'paper-148-training-evangelists-bethsaida',
        'paper-149-second-preaching-tour',
        'paper-150-third-preaching-tour',
        'paper-151-tarrying-and-teaching-seaside',
        'paper-152-events-leading-capernaum-crisis',
        'paper-153-crisis-capernaum',
        'paper-154-last-days-capernaum',
        'paper-155-fleeing-through-northern-galilee',
        'paper-156-sojourn-tyre-and-sidon',
        'paper-157-caesarea-philippi',
        'paper-158-mount-transfiguration',
        'paper-159-decapolis-tour',
        'paper-160-rodan-alexandria',
        'paper-161-further-discussions-rodan',
        'paper-162-feast-tabernacles',
        'paper-163-ordination-seventy-magadan',
        'paper-164-feast-dedication',
        'paper-165-perean-mission-begins',
        'paper-166-last-visit-northern-perea',
        'paper-167-visit-philadelphia',
        'paper-168-resurrection-lazarus',
        'paper-169-last-teaching-pella',
        'paper-170-kingdom-heaven',
        'paper-171-way-jerusalem',
        'paper-172-going-jerusalem',
        'paper-173-monday-in-jerusalem',
        'paper-174-tuesday-morning-in-temple',
        'paper-175-last-temple-discourse',
        'paper-176-tuesday-evening-mount-olivet',
        'paper-177-wednesday-rest-day',
        'paper-178-last-day-camp',
        'paper-179-last-supper',
        'paper-180-farewell-discourse',
        'paper-181-final-admonitions-and-warnings',
        'paper-182-in-gethsemane',
        'paper-183-betrayal-and-arrest-jesus',
        'paper-184-sanhedrin-court',
        'paper-185-trial-pilate',
        'paper-186-just-crucifixion',
        'paper-187-crucifixion',
        'paper-188-time-tomb',
        'paper-189-resurrection',
        'paper-190-morontia-appearances-jesus',
        'paper-191-appearances-apostles-and-other-leaders',
        'paper-192-appearances-in-galilee',
        'paper-193-final-appearances-and-ascension',
        'paper-194-bestowal-spirit-truth',
        'paper-195-after-pentecost',
        'paper-196-faith-jesus',
    ];
}
