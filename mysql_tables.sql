Table: delivery_dates
Columns:
WHSE int(11) PK 
WCSNUM int(11) PK 
WONUM int(11) PK 
BOXNUM int(11) PK 
SHIPZONE varchar(45) 
SHIPCLASS varchar(45) 
TRACER varchar(45) 
BOXSIZE varchar(45) 
HAZCLASS varchar(45) 
BOXLINES int(11) 
BOXWEIGHT decimal(10,2) 
ZIPCODE int(11) 
BOXVALUE decimal(12,2) 
DELIVERDATE date 
DELIVERTIME time 
LICENSE int(11) 
CARRIER varchar(45) 
SHIPDATE date 
SHIPTIME time 
BILLTO int(11) 
SHIPTO int(11) 
SHOULDDAYS decimal(6,2) 
ACTUALDAYS decimal(6,2) 
LATE int(2)

Sample Data:
# WHSE, WCSNUM, WONUM, BOXNUM, SHIPZONE, SHIPCLASS, TRACER, BOXSIZE, HAZCLASS, BOXLINES, BOXWEIGHT, ZIPCODE, BOXVALUE, DELIVERDATE, DELIVERTIME, LICENSE, CARRIER, SHIPDATE, SHIPTIME, BILLTO, SHIPTO, SHOULDDAYS, ACTUALDAYS, LATE
6, 37357486, 1, 2, MD3, MDU, 1Z1X10330394743044, CSE, , 1, 9.00, 23435, 114.00, 2025-02-25, 11:56:00, 146561872, MARYLAND SORT, 2025-02-27, 09:48:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 3, MD3, MDU, 1Z1X10330394743053, CSE, , 1, 9.00, 23435, 114.00, 2025-02-25, 11:56:00, 146561873, MARYLAND SORT, 2025-02-27, 09:48:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 4, MD3, MDU, 1Z1X10330394743062, CSE, , 1, 9.00, 23435, 114.00, 2025-02-25, 11:56:00, 146561874, MARYLAND SORT, 2025-02-27, 09:48:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 5, MD3, MDU, 1Z1X10330394743071, CSE, , 1, 9.00, 23435, 114.00, 2025-02-25, 11:56:00, 146561875, MARYLAND SORT, 2025-02-27, 09:48:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 6, MD3, MDU, 1Z1X10330394743080, CSE, , 1, 9.00, 23435, 114.00, 2025-02-25, 11:56:00, 146561876, MARYLAND SORT, 2025-02-27, 09:52:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 7, MD3, MDU, 1Z1X10330394743099, CSE, , 1, 9.00, 23435, 114.00, 2025-02-25, 11:56:00, 146561877, MARYLAND SORT, 2025-02-27, 09:48:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 8, MD3, MD3, 1Z1X10330394783715, CSE, , 1, 9.00, 23435, 134.40, 2025-02-26, 13:13:00, 146561878, MARYLAND SORT, 2025-02-27, 12:58:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 9, MD3, MD3, 1Z1X10330394783724, CSE, , 1, 9.00, 23435, 134.40, 2025-02-26, 13:13:00, 146561879, MARYLAND SORT, 2025-02-27, 12:58:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 10, MD3, MD3, 1Z1X10330394783733, CSE, , 1, 9.00, 23435, 134.40, 2025-02-26, 13:13:00, 146561880, MARYLAND SORT, 2025-02-27, 12:58:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 11, MD3, MD3, 1Z1X10330394783742, CSE, , 1, 9.00, 23435, 134.40, 2025-02-26, 13:13:00, 146561881, MARYLAND SORT, 2025-02-27, 12:58:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 12, MD3, MD3, 1Z1X10330394783751, CSE, , 1, 9.00, 23435, 134.40, 2025-02-26, 13:13:00, 146561882, MARYLAND SORT, 2025-02-27, 12:58:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 13, MD3, MDU, 1Z1X10330394759742, CSE, , 1, 11.00, 23435, 43.60, 2025-02-25, 11:56:00, 146561883, MARYLAND SORT, 2025-02-27, 09:49:00, 1737552, 3217703, 1.00, 1.00, 0
6, 37357486, 1, 14, MD3, MDU, 1Z1X10330394759751, CSE, , 1, 11.00, 23435, 43.60, 2025-02-25, 11:56:00, 146561884, MARYLAND SORT, 2025-02-27, 09:46:00, 1737552, 3217703, 1.00, 3.00, 1
6, 37357486, 1, 15, MD3, MDU, 1Z1X10330394759760, CSE, , 1, 23.00, 23435, 43.60, 2025-02-25, 11:56:00, 146561885, MARYLAND SORT, 2025-02-27, 10:03:00, 1737552, 3217703, 1.00, 3.00, 1
6, 37357486, 1, 16, MD3, MD3, 1Z1X10330394739415, CSE, , 1, 4.00, 23435, 15.24, 2025-02-26, 13:13:00, 146561886, MARYLAND SORT, 2025-02-27, 12:00:00, 1737552, 3217703, 1.00, 4.00, 1
6, 37357486, 1, 17, MD3, MD3, 1Z1X10330394739424, CSE, , 1, 4.00, 23435, 15.24, 2025-02-26, 13:13:00, 146561887, MARYLAND SORT, 2025-02-27, 12:00:00, 1737552, 3217703, 1.00, 4.00, 1
6, 37357486, 1, 18, MD3, MD3, 1Z1X10330394739433, CSE, , 1, 4.00, 23435, 15.24, 2025-02-26, 13:13:00, 146561888, MARYLAND SORT, 2025-02-27, 12:00:00, 1737552, 3217703, 1.00, 4.00, 1
6, 37357486, 1, 19, MD3, MDU, 1Z1X10330394760632, #E2, , 1, 2.00, 23435, 14.66, 2025-02-26, 13:13:00, 146561889, MARYLAND SORT, 2025-02-27, 09:33:00, 1737552, 3217703, 1.00, 4.00, 1
