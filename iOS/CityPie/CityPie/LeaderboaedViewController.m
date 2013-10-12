//
//  LeaderboaedViewController.m
//  CityPie
//
//  Created by Haifisch Laws on 10/6/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import "LeaderboaedViewController.h"

@interface LeaderboaedViewController ()

@end

@implementation LeaderboaedViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    UIImage *menuImage = [SVGKImage imageNamed:@"menu_icon.svg"].UIImage;
    self.revealButtonItem = [[UIBarButtonItem alloc] initWithImage:menuImage style:UIBarButtonItemStyleBordered target:self.revealViewController action:@selector(revealToggle:)];
    self.navigationItem.leftBarButtonItem = self.revealButtonItem;
    self.navigationController.navigationBar.titleTextAttributes = @{NSForegroundColorAttributeName :[UIColor whiteColor], NSFontAttributeName: [UIFont fontWithName:@"Helvetica" size:20]};
    self.revealButtonItem.tintColor = [UIColor whiteColor];
    [self.navigationController.navigationBar addGestureRecognizer: self.revealViewController.panGestureRecognizer];
    [self.navigationController.navigationBar setBarTintColor:[UIColor colorWithRed:49/255.0f green:49/255.0f blue:49/255.0f alpha:1]];
    [self setEdgesForExtendedLayout:UIRectEdgeNone];
    self.tableView.backgroundColor = [UIColor colorWithRed:224/255.0 green:219/255.0 blue:208/255.0 alpha:1];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



/*
// Override to support conditional editing of the table view.
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the specified item to be editable.
    return YES;
}
*/

/*
// Override to support editing the table view.
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        // Delete the row from the data source
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    }   
    else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
    }   
}
*/

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath
{
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/

/*
#pragma mark - Navigation

// In a story board-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}

 */

@end
