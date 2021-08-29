<?php

function elitify($str, $seed) {
  $result="";
  for ($i=0;$i<strlen($str);$i++) {
    if (hexdec(substr($seed,$i%strlen($seed),1))<1)
      $l=strtr(substr($str,$i,1),"isoage","150493");
    else if (hexdec(substr($seed,$i%strlen($seed),1))<2)
      $l=strtr(substr($str,$i,1),"asit","@$!+");
    else $l=substr($str,$i,1);
    $result.=$l;
  }
  return $result;
}

function generate($seed) {
  $prefix=["superior","anonymous","high","elite","bizarre","binary","evil","deranged","mad","krazy"];
  $titles=["Master","Lady","Sir","Professor","Lord","Colonel","Mr.","Cardinal","Miss","Dr.",
    "Duke","Comrade","Count","Baron","Darth","General"];
  $part1=["null","alpha","binary","kernel","chaos","fire","shadow","core","void","rouge","dark",
    "hex","crypto","acid","bug","stack","night","storm","hax","hacker","neo","bit","space","shock","omega","Xenu"];
  $part2=["burn","kernel","hash","master","core","hax","stalker","droid","driver","arrow","sploit",
    "blaze","king","viper","wasp","god","exploit","sheriff","riddle","bug","druid","wizard","pope",
    "hack","sheik","plague","dagger","lord","snake","guru","file","wolf","crack","elf","acid","prophet"];

  $hash = md5($seed);
  $result = "";
  if (hexdec(substr($hash,0,4)) > 0xb000)
    $result .=  $prefix[hexdec(substr($hash,0,4))%count($prefix)]." ";
  if (hexdec(substr($hash,4,4)) > 0xb000)
    $result .= $titles[hexdec(substr($hash,4,4))%count($titles)]." ";
  $result.=$part1[hexdec(substr($hash,8,4))%count($part1)];
  if (strlen($result)>10 ) $result.="-";
  else $result.=" ";
  $result .= $part2[hexdec(substr($hash,12,4))%count($part2)];
  $result = elitify($result,substr($hash,16,16));
  return $result;
}


$all = array();

$prefixes=["superior","anonymous","high","elite","bizarre","binary","evil","deranged","mad","krazy"];
$titles=["Master","Lady","Sir","Professor","Lord","Colonel","Mr.","Cardinal","Miss","Dr.",
	"Duke","Comrade","Count","Baron","Darth","General"];
$parts1=["null","alpha","binary","kernel","chaos","fire","shadow","core","void","rouge","dark",
	"hex","crypto","acid","bug","stack","night","storm","hax","hacker","neo","bit","space","shock","omega","Xenu"];
$parts2=["burn","kernel","hash","master","core","hax","stalker","droid","driver","arrow","sploit",
	"blaze","king","viper","wasp","god","exploit","sheriff","riddle","bug","druid","wizard","pope",
	"hack","sheik","plague","dagger","lord","snake","guru","file","wolf","crack","elf","acid","prophet"];

foreach($prefixes as $prefix) {
	foreach($titles as $title) {
		foreach($parts1 as $part1) {
			foreach($parts2 as $part2) {
				$all[$part1 . " " . $part2] = true;
				$all[$title . " " . $part1 . " " . $part2] = true;
				$all[$prefix . " " . $part1 . " " . $part2] = true;
				$all[$prefix . " " . $title . " " . $part1 . " " . $part2] = true;

				$all[$part1 . "-" . $part2] = true;
				$all[$title . " " . $part1 . "-" . $part2] = true;
				$all[$prefix . " " . $part1 . "-" . $part2] = true;
				$all[$prefix . " " . $title . " " . $part1 . "-" . $part2] = true;
			}
		}
	}
}

foreach($all as $nick => $_) {
	$rev = strrev($nick);

	if($nick == generate($rev)) {
		print_r(array($nick, $rev));
	}
}

?>

