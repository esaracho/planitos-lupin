#!/bin/bash

tree -J > ../json/ALL.json
ls | grep "^MAQ" | tree --fromfile -J > ../json/MAQ.json
ls | grep "^ANC" | tree --fromfile -J > ../json/ANC.json
ls | grep "^ARV" | tree --fromfile -J > ../json/ARV.json
ls | grep "^RC" | tree --fromfile -J > ../json/RC.json
ls | grep "^BAR" | tree --fromfile -J > ../json/BAR.json
ls | grep "^BT" | tree --fromfile -J > ../json/BT.json
ls | grep "^COM" | tree --fromfile -J > ../json/COM.json
ls | grep "^ELC" | tree --fromfile -J > ../json/ELC.json
ls | grep "^GL" | tree --fromfile -J > ../json/GL.json
ls | grep -w "^MG" | tree --fromfile -J > ../json/MG.json
ls | grep "^MGI" | tree --fromfile -J > ../json/MGI.json
ls | grep "^PLC" | tree --fromfile -J > ../json/PLC.json
ls | grep -w "^PL" | tree --fromfile -J > ../json/PL.json
ls | grep "^TA" | tree --fromfile -J > ../json/TA.json
ls | grep "^UC" | tree --fromfile -J > ../json/UC.json
ls | grep "^CHT" | tree --fromfile -J > ../json/CHT.json
ls | grep "^OTR" | tree --fromfile -J > ../json/OTR.json
ls | grep "^RIN" | tree --fromfile -J > ../json/RIN.json
ls | grep "^CIC" | tree --fromfile -J > ../json/CIC.json
ls | grep "^FOT" | tree --fromfile -J > ../json/FOT.json
ls | grep "^AST" | tree --fromfile -J > ../json/AST.json
ls | grep "^MSC" | tree --fromfile -J > ../json/MSC.json
