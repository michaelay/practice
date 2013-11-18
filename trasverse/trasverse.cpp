#include <iostream>
#include <stack>
#include <queue>
#include "node.h" 

void create_tree(const NodePtr& rootNodePtr);
void dfs(const NodePtr& rootNodePtr); 
void bfs(const NodePtr& rootNodePtr); 

int main( int argc, const char* argv[] ) 
{
  std::cout << "Create tree..." << std::endl; 

  NodePtr rootNodePtr(new Node("Root"));
  create_tree(rootNodePtr);

  std::cout << "Parsing tree dfs..." << std::endl; 
  dfs(rootNodePtr);

  std::cout << "Parsing tree bfs..." << std::endl; 
  bfs(rootNodePtr);

  return 0;
}

void create_tree(const NodePtr& rootNodePtr) 
{
  NodePtr childA1(new Node("A1")); 
  NodePtr childB1(new Node("B1")); 
  NodePtr childC1(new Node("C1")); 
  rootNodePtr->addChild(childA1);
  rootNodePtr->addChild(childB1);
  rootNodePtr->addChild(childC1);

  NodePtr childA11(new Node("A11")); 
  NodePtr childA12(new Node("A12")); 
  NodePtr childA13(new Node("A13")); 
  childA1->addChild(childA11);
  childA1->addChild(childA12);
  childA1->addChild(childA13);

  NodePtr childC11(new Node("C11")); 
  NodePtr childC12(new Node("C12")); 
  NodePtr childC13(new Node("C13")); 
  childC1->addChild(childC11);
  childC1->addChild(childC12);
  childC1->addChild(childC13);
} 

void dfs(const NodePtr& rootNodePtr) 
{
  std::stack<NodePtr> stack; 
  stack.push(rootNodePtr);

  while (!stack.empty()) { 
    NodePtr currentNodePtr = stack.top(); 
    stack.pop();
    std::cout << currentNodePtr->getName() << std::endl; 

    NodeList children = currentNodePtr->getChildren(); 
    for (NodeList::reverse_iterator iter = children.rbegin(); iter != children.rend(); ++iter) 
    {
      stack.push(*iter); 
    } 
  } 
} 

void bfs(const NodePtr& rootNodePtr) 
{
  std::queue<NodePtr> queue; 
  queue.push(rootNodePtr); 

  while (!queue.empty()) 
  {
    NodePtr currentNodePtr = queue.front(); 
    queue.pop();
    std::cout << currentNodePtr->getName() << std::endl; 

    NodeList children = currentNodePtr->getChildren(); 
    for (NodeList::iterator iter = children.begin(); iter != children.end(); ++iter) 
    {
      queue.push(*iter); 
    } 
  } 
} 

