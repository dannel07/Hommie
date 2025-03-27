part of 'home_import.dart';

class Home extends StatefulWidget {
  const Home({super.key});

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {

  late HomeController controller = controller = Get.put(HomeController());
  late bool isDarkMode;

  @override
  void initState() {
    super.initState();
    controller.getHomeDetail();
    controller.selectedItem.value = 0;
    controller.passingStatus.value = "Recommended";
    controller.filterList("Recommended");
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: homeAppBar(MyString.bookNest, true, controller.themeController.isDarkMode.value),
      body: Obx(() => SingleChildScrollView(
        child: Column(
          children: [
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 15),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const SizedBox(height: 10),
                  Text("Hello, Anisetus 👋", style: TextStyle(color: controller.themeController.isDarkMode.value ? MyColors.white : MyColors.successColor, fontWeight: FontWeight.w700, fontSize: 26)),
                  const SizedBox(height: 18),
                  InkWell(
                    onTap: () {
                      Get.to(const Search(status: 'home'));
                    },
                    child: Container(
                      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
                      width: MediaQuery.of(context).size.width,
                      decoration: BoxDecoration(
                        color: controller.themeController.isDarkMode.value
                            ? MyColors.darkSearchTextFieldColor
                            : MyColors.searchTextFieldColor,
                        borderRadius: BorderRadius.circular(15),
                      ),
                      child: Row(
                        children: [
                          SvgPicture.asset(MyImages.unSelectedSearch,
                            colorFilter: ColorFilter.mode(controller.themeController.isDarkMode.value ? MyColors.white : MyColors.onBoardingDescriptionDarkColor, BlendMode.srcIn),
                            width: 22,
                          ),
                          const SizedBox(width: 15),
                          Text(MyString.search, style: TextStyle(color: controller.themeController.isDarkMode.value ? MyColors.white : MyColors.onBoardingDescriptionDarkColor,fontWeight: FontWeight.w400, fontSize: 14)),
                          const Spacer(),
                          InkWell(
                            onTap: () {
                              showModalBottomSheet(
                                backgroundColor: Get.isDarkMode ? MyColors.scaffoldDarkColor : Colors.white,
                                useSafeArea: true,
                                isScrollControlled: true,
                                context: context,
                                builder: (context) {
                                  return FilterBottomSheet();
                                },
                              );
                              // return filterBottomSheet(context);
                            },
                            child: Container(
                              padding: const EdgeInsets.all(5),
                              child: SvgPicture.asset(MyImages.filter, colorFilter: ColorFilter.mode(controller.themeController.isDarkMode.value ? MyColors.white : MyColors.primaryColor, BlendMode.srcIn)),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 20),
                  // Row(
                  //   mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  //   children: [
                  //     Expanded(
                  //       child: InkWell(
                  //         onTap: () {
                  //           controller.selectedItem.value = 0;
                  //           controller.passingStatus.value = 'Recommended';
                  //           controller.filterList('Recommended');
                  //         },
                  //         child: customContainerButton(
                  //           MyString.recommended,
                  //           0,
                  //           controller.selectedItem.value,
                  //           controller.themeController.isDarkMode.value,
                  //         ),
                  //       ),
                  //     ),
                  //     const SizedBox(width: 5),
                  //     Expanded(
                  //       child: InkWell(
                  //         onTap: () {
                  //           controller.selectedItem.value = 1;
                  //           controller.passingStatus.value = 'Popular';
                  //           controller.filterList('Popular');
                  //         },
                  //         child: customContainerButton(
                  //           MyString.popular,
                  //           1,
                  //           controller.selectedItem.value,
                  //           controller.themeController.isDarkMode.value,
                  //         ),
                  //       ),
                  //     ),
                  //     const SizedBox(width: 5),
                  //     Expanded(
                  //       child: InkWell(
                  //         onTap: () {
                  //           controller.selectedItem.value = 2;
                  //           controller.passingStatus.value = 'Trending';
                  //           controller.filterList('Trending');
                  //         },
                  //         child: customContainerButton(
                  //           MyString.trending,
                  //           2,
                  //           controller.selectedItem.value,
                  //           controller.themeController.isDarkMode.value,
                  //         ),
                  //       ),
                  //     ),
                  //   ],
                  // ),
                  SizedBox(
                    height: 40,
                    child: ListView.builder(
                      scrollDirection: Axis.horizontal,
                      shrinkWrap: true,
                      itemCount: MyString.itemSelect.length,
                      itemBuilder: (context, index) {
                        return Row(
                          children: [
                            InkWell(
                              onTap: () {
                                controller.selectedItem.value = index;
                                switch(index) {
                                  case 0 :
                                    controller.passingStatus.value = 'Recommended';
                                    break;
                                  case 1 :
                                    controller.passingStatus.value = 'Popular';
                                    break;
                                  case 2 :
                                    controller.passingStatus.value = 'Trending';
                                    break;
                                  default : controller.passingStatus.value = 'New Arrive';
                                }
                                controller.filterList(controller.passingStatus.value);
                              },
                              child: Container(
                                alignment: Alignment.center,
                                decoration: BoxDecoration(
                                    color: controller.selectedItem.value == index
                                        ? controller.themeController.isDarkMode.value
                                          ? MyColors.successColor
                                          : MyColors.black
                                        : controller.themeController.isDarkMode.value
                                          ? MyColors.scaffoldDarkColor
                                          : MyColors.white,
                                    borderRadius: BorderRadius.circular(20),
                                    border: Border.all(
                                        color: controller.selectedItem.value == index
                                            ? controller.themeController.isDarkMode.value
                                            ? MyColors.successColor
                                            : Colors.black
                                            : controller.themeController.isDarkMode.value
                                            ? MyColors.white
                                            : MyColors.black
                                    )
                                ),
                                padding: const EdgeInsets.symmetric(horizontal: 18),
                                child: Text(
                                  MyString.itemSelect[index],
                                  style: TextStyle(
                                      color: controller.selectedItem.value == index
                                          ? MyColors.white
                                          : controller.themeController.isDarkMode.value
                                          ? MyColors.white
                                          : MyColors.black,
                                      fontWeight: FontWeight.w600, fontSize: 14),
                                ),
                              ),
                            ),
                            const SizedBox(width: 12),
                          ],
                        );
                      },
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 20),
            SizedBox(
              height: 300,
              child: controller.isLoading.value
                ? Center(child: CircularProgressIndicator(
                  color: controller.themeController.isDarkMode.value ? Colors.white : MyColors.successColor),
                )
                : ListView.builder(
                  scrollDirection: Axis.horizontal,
                  shrinkWrap: true,
                  itemCount: controller.filterListView.length,
                  itemBuilder: (context, index) {
                  return Row(
                    children: [
                      const SizedBox(width: 10),
                      InkWell(
                        onTap: () {
                          Get.toNamed("/hotelDetail", arguments: {'data' : controller.homeDetails[index]});
                        },
                        child: Container(
                          padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 20),
                          width: 230,
                          decoration: BoxDecoration(
                              color: MyColors.disabledColor,
                              borderRadius: BorderRadius.circular(40),
                              image: DecorationImage(image: NetworkImage("${controller.filterListView[index].image}"), fit: BoxFit.cover)
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                mainAxisAlignment: MainAxisAlignment.end,
                                children: [
                                  Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
                                    decoration: BoxDecoration(
                                        color: MyColors.primaryColor,
                                        borderRadius: BorderRadius.circular(20)
                                    ),
                                    child: Row(
                                      mainAxisAlignment: MainAxisAlignment.center,
                                      children: [
                                        SvgPicture.asset(MyImages.whiteStar, width: 10,),
                                        const SizedBox(width: 5),
                                        Text("${controller.homeDetails[index].rate}", style: const TextStyle(color: MyColors.white, fontWeight: FontWeight.w600, fontSize: 12),),
                                      ],
                                    ),
                                  ),
                                ],
                              ),
                              const Spacer(),
                              Text("${controller.homeDetails[index].hotelName}", style: const TextStyle(color: MyColors.white, fontWeight: FontWeight.w700, fontSize: 18),),
                              const SizedBox(height: 5),
                              Text("${controller.homeDetails[index].location}", style: const TextStyle(color: MyColors.white, fontWeight: FontWeight.w400, fontSize: 14),),
                              const SizedBox(height: 5),
                              Row(
                                children: [
                                  Text("${controller.homeDetails[index].price}", style: const TextStyle(color: MyColors.white, fontWeight: FontWeight.w600, fontSize: 17),),
                                  const Text(" / Bulan", style: TextStyle(color: MyColors.white, fontWeight: FontWeight.w400, fontSize: 14),),
                                  const Spacer(),
                                  SvgPicture.asset(MyImages.bookMarkLight),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ),
                      const SizedBox(width: 10),
                    ],
                  );
                },
              ),
            ),
            const SizedBox(height: 15),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 15),
              child: Column(
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text(MyString.recentlyBooked, style: TextStyle(fontWeight: FontWeight.w700, fontSize: 16)),
                      InkWell(
                        onTap: () {
                          Get.toNamed("/RecentlyBooked");
                        },
                        child: const Text(MyString.seeAll, style: TextStyle(fontWeight: FontWeight.w700, fontSize: 14)),
                      ),
                    ],
                  ),
                  const SizedBox(height: 15),
                  SizedBox(
                    child: ListView.builder(
                      physics: const NeverScrollableScrollPhysics(),
                      shrinkWrap: true,
                      itemCount: controller.recentlyBooked.length,
                      itemBuilder: (context, index) {
                        return InkWell(
                          onTap: () {
                            Get.toNamed("/hotelDetail", arguments: {'data' : controller.homeDetails[index]});
                          },
                            child: VerticalView(index: index),
                        );
                      },
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),)
    );
  }
}
